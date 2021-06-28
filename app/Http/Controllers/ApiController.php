<?php

namespace App\Http\Controllers;

use App\Helpers\Rate;
use App\Models\System;
use App\Notifications\AdminNotifications;
use App\Notifications\OrderAssignee;
use App\Notifications\OrderCreate;
use App\Notifications\OrderDecline;
use App\Notifications\ReferralBonusPay;
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

    public function assigneeOrderByUser()
    {
        $order = Order::where('status', 'created')->first();
        $user = Auth::user();

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
    public function declineOrderByUser()
    {
        $order = Order::where('status', 'created')->first();
        $user = Auth::user();

        // Send message via telegram
        if (config('notifications')) $user->notify(new OrderDecline($order));


        $order->forceDelete();
        return $order->id;
    }



}
