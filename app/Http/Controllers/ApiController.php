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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
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

    public function createOrder(Request $request)
    {
        $user = User::where('uid', $request->input('user_uid'))->first();
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
                    $admin->notify(new AdminNotifications($message));
                }
                $user->notify(new OrderCreate($order));
                return $order->id;
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
            $admin->notify(new AdminNotifications($message));
        }

        $user->notify(new OrderAssignee($order));
        $order->status = 'assignee';
        $order->save();
        return $order->id;
    }


    public function confirmOrder($id)
    {
        $order = Order::find($id);
        $order->status = 'completed';


        $systemWallet = System::findOrFail(1);
        if ($systemWallet->getWallet('DHB')->balanceFloat >= $order->amount) {

            //deposit to user wallet
            $user = User::where('uid', $order->user_uid)->first();


            //withdraw from system wallet
            $systemWallet->getWallet('DHB')->transfer( $user->getWallet('DHB'), $order->amount * 100);
            $user->getWallet('DHB')->refreshBalance();
            $systemWallet->getWallet('DHB')->refreshBalance();

            $currency = $order->currency;
            $curAmount = $order->amount / $order->rate;



            // Начисление рефок
            $ref = User::where('uid', $order->user_uid)->first();

            $curAmount = $this->payReferral($ref, $currency, $curAmount);

            // deposit to system wallet
            $systemWallet->getWallet($currency)->depositFloat($order->amount, array('destination' => 'tokenSale'));
            $systemWallet->getWallet($currency)->refreshBalance();

            // сохраняем модель
            $order->save();
            return $order->id;
        }
        else {

            $headers = array (
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            );

            return response(['error'=>true, 'error-msg' => 'Баланс системы меньше запрашиваемой суммы'], 404, $headers, JSON_UNESCAPED_UNICODE);
        }
    }


    public function declineOrder($id)
    {
        $order = Order::find($id);
        $user = User::where('uid', $order->user_uid)->first();
        $user->notify(new OrderDecline($order));
        $order->forceDelete();
        return $order->id;
    }

    public function declineOrderByUser()
    {
        $order = Order::where('status', 'created')->first();
        $user = Auth::user();
        $user->notify(new OrderDecline($order));
        $order->forceDelete();
        return $order->id;
    }


    public function payReferral(User $user, $currency, $amount) {
        $curAmount = 0;

        $tax = 9; // Процент на первом уровне
        $refAmount = 0;
        $curAmount = 0;
        while ($user->referred_by && $tax > 0) {
            $user = User::where('affiliate_id', $user->referred_by)->first();
            $refAmount = ($amount * $tax ) / 100;
            $user->getWallet($currency)->depositFloat($refAmount, array('destination' => 'referral'));
            $user->getWallet($currency)->refreshBalance();
            $user->notify(new ReferralBonusPay(array('amount' => $refAmount, 'currency' => $currency)));
            $curAmount = $amount - $refAmount;
            $tax = $tax - 3;
        }
        return $curAmount;
    }


    public function startTokenSale(Request $request)
    {
        $system = System::findOrFail(1);
        $system->getWallet('DHB')->depositFloat('2000000');
        $system->getWallet('DHB')->refreshBalance();
        $system->rate = 0.05;
        $system->stage = 1;
        $system->save();
        return true;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function withdrawPayment(Request $request)
    {

        $amount = $request->input('amount');
        $currency = $request->input('currency');
        $destination = $request->input('destination');

        $systemWallet = System::findOrFail(1);
        $systemWallet->getWallet($currency)->withdrawFloat($amount, array('destination' => $destination));
        return true;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
