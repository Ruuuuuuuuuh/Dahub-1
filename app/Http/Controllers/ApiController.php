<?php

namespace App\Http\Controllers;

use App\Helpers\Rate;
use App\Models\Currency;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\System;
use App\Models\UserConfig;
use App\Notifications\AcceptDepositOrder;
use App\Notifications\AdminNotifications;
use App\Notifications\OrderAssignee;
use App\Notifications\OrderCreate;
use App\Notifications\OrderDecline;
use App\Notifications\ReferralBonusPay;
use Bavix\Wallet\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{

    /**
     * Deposit to users Wallet
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function depositFloat(Request $request)
    {
        $uid = $request->input('uid');
        $amount = $request->input('amount');
        $user = User::where('uid', $uid)->first();
        $user->getWallet('DHB')->depositFloat($amount);
        $user->getWallet('DHB')->refreshBalance();
        return $user->getWallet('DHB')->balanceFloat;
    }


    /**
     * Create Order from users
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function createOrder(Request $request)
    {
        $user = Auth::user();
        $system = System::find(1);

        $headers = array (
            'Content-Type' => 'application/json; charset=UTF-8',
            'charset' => 'utf-8'
        );

        if ($request->input('amount') <= $system->getFreeTokens() && $request->input('amount') <= 333333)
            if (!empty($user->orders()->notCompleted()->get())) {
                $order = Order::create([
                    'user_uid'       => $request->input('user_uid'),
                    'destination'    => $request->input('destination'),
                    'currency'       => $request->input('currency'),
                    'amount'         => $request->input('amount'),
                    'rate'           => Rate::getRates($request->input('currency')),
                    'status'         => 'created',
                ]);
                $order->save();
                $admins = User::where('roles', 'admin')->get();
                foreach ($admins as $admin) {
                    $message = 'Новая заявка ' . $order->id . ' на покупку ' . $order->amount . ' DHB. [Написать пользователю](tg://user?id='.$user->uid.')';
                    if (config('notifications')) $admin->notify(new AdminNotifications($message));
                }
                if (config('notifications')) $user->notify(new OrderCreate($order));
                return response($order->id, 200);
            }
            else {
                return response(['error'=> true, 'error-msg' => 'У вас уже есть активная заявка'],404, $headers, JSON_UNESCAPED_UNICODE);
            }
        else {
            return response(['error'=> true, 'error-msg' => 'Не достаточно токенов для получения'],404, $headers, JSON_UNESCAPED_UNICODE);
        }

    }

    /**
     * Create self order by user
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function createOrderByUser(Request $request) {
        $user = Auth::user();
        $headers = array (
            'Content-Type' => 'application/json; charset=UTF-8',
            'charset' => 'utf-8'
        );
        if ($request->has('amount') && $request->input('amount')!= null) {
            $order = Order::create([
                'user_uid'       => $user->uid,
                'destination'    => $request->input('destination'),
                'payment'        => $request->input('payment'),
                'currency'       => $request->input('currency'),
                'amount'         => $request->input('amount'),
                'status'         => 'created',
                'rate'           => 0
            ]);
            $order->save();
            return response($order->id, 200, $headers);
        }
        else return response(['error'=> true, 'error-msg' => 'Вы не ввели сумму'],404, $headers, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Assignee self order by User
     * @return mixed
     */
    public function assigneeOrderByUser(Request $request)
    {
        $id = $request->input('id');
        $user = Auth::user();
        $order = Order::where('id', $id)->where('user_uid', $user->uid)->first();

        $admins = User::where('roles', 'admin')->get();
        foreach ($admins as $admin) {
            $message = 'Заявка ' . $order->id . ' на получение ' . $order->amount . ' DHB подтверждена пользователем. [Написать пользователю](tg://user?id='.$user->uid.')';
            if (config('notifications')) $admin->notify(new AdminNotifications($message));
        }

        if (config('notifications')) $user->notify(new OrderAssignee($order));
        $order->status = 'assignee';
        $order->save();
        return $order->id;
    }


    /**
     * Отмена заявки пользовтелем
     *
     * @return mixed
     */
    public function declineOrderByUser(Request $request)
    {
        $id = $request->input('id');
        $user = Auth::user();
        $order = Order::where('id', $id)->where('user_uid', $user->uid)->first();

        // Send message via telegram
        if (config('notifications')) $user->notify(new OrderDecline($order));


        $order->forceDelete();
        return $order->id;
    }

    public function getTransactions(Request $request) {
        $value = $request->input('value');
        $user = User::where('uid', $value)->first();
        if ($user) {
            $ordersList = array();
            $i = 0;
            foreach ($user->orders()->get() as $order) {
                $ordersList[$i]['currency'] = $order->currency;
                $ordersList[$i]['amount'] = $order->amount;
                $transactions = $order->transactions();
                foreach ($transactions as $transaction) {
                    if ($transaction->payable_type == 'App\Models\System') {
                        $ordersList[$i]['amountSource'] = $transaction->amount / 10 ** $transaction->wallet->decimal_places;
                        $ordersList[$i]['date'] = $transaction->created_at->diffForHumans() . ', ' . $transaction->created_at->Format('H:s');
                    } else {
                        $ordersList[$i]['uuid'] = $transaction->uuid;
                    }
                }
                $i++;
            }
            return json_encode($ordersList, JSON_FORCE_OBJECT | JSON_NUMERIC_CHECK);
        }
        else {
            $transaction = Transaction::where('uuid', $value)->firstOrFail();
            $order = Order::where('id', $transaction->meta['order_id'])->firstOrFail();
            $orderList = array();
            $orderList[0]['currency'] = $order->currency;
            $orderList[0]['amount'] = $order->amount;
            $transactions = $order->transactions();
            foreach ($transactions as $transaction) {
                if ($transaction->payable_type == 'App\Models\System') {
                    $orderList[0]['amountSource'] = $transaction->amount / 10 ** $transaction->wallet->decimal_places;
                    $orderList[0]['date'] = $transaction->created_at->diffForHumans() . ', ' . $transaction->created_at->Format('H:s');
                } else {
                    $orderList[0]['uuid'] = $transaction->uuid;
                }
            }
            return json_encode($orderList, JSON_FORCE_OBJECT | JSON_NUMERIC_CHECK);
        }
    }

    public function getPayments(Request $request) {
        $currency = $request->input('currency');
        return Currency::where('title', $currency)->first()->payments()->get();
    }

    /**
     * Сохранение юзер конфига
     * @param Request $request
     * @return bool
     */
    public function saveUserConfig(Request $request): bool
    {
        $meta  = $request->input('meta');
        $value = $request->input('value');
        UserConfig::updateOrCreate(
            ['user_uid' => Auth::user()->uid, 'meta' => $meta],
            ['value' => $value]
        );
        return true;
    }

    public function addPaymentDetails(Request $request) {
        $user = Auth::user();
        $payment = $request->input('payment');
        $address = $request->input('address');
        $holder = $request->input('holder_name');
        $payment_details = PaymentDetail::create(
            [
                'user_uid' => $user->uid,
                'payment_id' => Payment::where('title', $payment)->firstOrFail()->id,
                'address' => $address,
                'holder' => $holder,
            ],
        );
        $data[]       = [
            'user_uid' => $user->uid,
            'payment' => $payment,
            'address' => $address,
            'holder' => $holder,
            'id'    => $payment_details->id
        ];
        return response()->json($data);
    }

    public function getPaymentDetails() {
        $user = Auth::user();
        return $user->paymentDetails()->with('payment');
    }

    public function acceptOrderByGate(Request $request) {
        $user = Auth::user();
        $mode = UserConfig::where('user_uid', $user->uid)->firstOrFail()->value;
        if ($user->isGate()) {
            $order = Order::where('id', $request->input('id'))->firstOrFail();
            if ($order->status == 'created') {
                $order->gate = $user->uid;
                $order->payment_details = $request->input('payment_details');
                $order->status = 'accepted';
                $order->save();
                $owner = User::where('uid', $order->user_uid)->first();
                $owner->notify(new AcceptDepositOrder($order));
                return $order->id;
            }
        }
    }

    public function confirmOrderByGate(Request $request) {
        $user = Auth::user();
        $order = Order::where('id', $request->input('id'))->firstOrFail();
        $owner = $order->user()->first();
        $headers = array (
            'Content-Type' => 'application/json; charset=UTF-8',
            'charset' => 'utf-8'
        );
        if ($order->gate == $user->uid) {
            if (($user->getBalanceFree($order->currency) > $order->amount) || $user->isAdmin()) {
                $transaction = $owner->getWallet($order->currency)->depositFloat($order->amount, array('destination' => 'deposit to wallet'));
                $owner->getWallet($order->currency)->refreshBalance();
                $user->freezeTokens($order->currency, $order->amount);
                $order->status = 'completed';
                $order->transaction()->attach($transaction->id);
                $order->save();
                return $order->id;
            }
            else response(['error'=>true, 'error-msg' => 'Недостаточно баланса'], 404, $headers, JSON_UNESCAPED_UNICODE);
        }
        else {

            return response(['error'=>true, 'error-msg' => 'У вас нет прав на эту операцию'], 404, $headers, JSON_UNESCAPED_UNICODE);
        }
    }
}
