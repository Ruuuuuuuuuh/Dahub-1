<?php


namespace App\Http\Controllers;

use App\Helpers\Rate;
use App\Models\System;
use App\Models\Tag;
use App\Models\Wallet;
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

class SystemApiController extends Controller
{
    public function generateUserWallets() {
        $users = User::all();
        foreach ($users as $user) {
            $user->createWallet(
                [
                    'name' => 'USDT',
                    'slug' => 'USDT',
                ]
            );
            $user->createWallet(
                [
                    'name' => 'BTC',
                    'slug' => 'BTC',
                    'decimal_places' => '8'
                ]
            );
            $user->createWallet(
                [
                    'name' => 'ETH',
                    'slug' => 'ETH',
                    'decimal_places' => '6'
                ]
            );

            $user->createWallet(
                [
                    'name' => 'DHB',
                    'slug' => 'DHB',
                ]
            );
        }
    }


    public function startTokenSale()
    {
        $system = System::findOrFail(1);
        //$system->getWallet('DHBFundWallet')->depositFloat('12196300');
        $system->getWallet('DHBFundWallet')->refreshBalance();
        $system->getWallet('DHBFundWallet')->transferFloat( $system->getWallet('TokenSale'), 2000000, array('destination' => 'StartTokenSale'));
        /*$system->createWallet(
            [
                'name' => 'USDT',
                'slug' => 'USDT',
            ]
        );
        $system->createWallet(
            [
                'name' => 'BTC',
                'slug' => 'BTC',
                'decimal_places' => '8'
            ]
        );
        $system->createWallet(
            [
                'name' => 'ETH',
                'slug' => 'ETH',
                'decimal_places' => '6'
            ]
        );
        $system->save();*/
        return true;
    }

    /**
     * Установка курса DHB/USDT.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return boolean
     */
    public function setDHBRate(Request $request)
    {
        $system = System::findOrFail(1);
        $system->rate = $request->input('rate');
        $system->save();
        return true;
    }

    /**
     * Вывод токенов из системного кошелька.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function withdrawPayment(Request $request)
    {

        $amount = $request->input('amount');
        $currency = $request->input('currency');
        $destination = $request->input('destination');
        if (!Tag::where('name', $destination)->exists()) {
            $tag = new Tag;
            $tag->name = $destination;
            $tag->save();
        }

        $systemWallet = System::findOrFail(1);
        $systemWallet->getWallet($currency)->withdrawFloat($amount, array('destination' => $destination));
        return true;
    }

    public function sendTokens(Request $request)
    {

        $amount = $request->input('amount');
        $currency = $request->input('currency');
        $destination = false;
        if ($request->has('destination')) $destination = $request->input('destination');

        $username = $request->input('username');
        $user = User::where('uid', $username)->first();
        if ($user) {
            if ($destination) {
                if (!Tag::where('name', $destination)->exists()) {
                    $tag = new Tag;
                    $tag->name = $destination;
                    $tag->save();
                }
            }

            $systemWallet = System::findOrFail(1);
            $systemWallet->getWallet($currency)->transferFloat($user->getWallet($currency), $amount, array('destination' => $destination));
            return 'Успешно переведено';
        }
        else {
            $headers = array (
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            );
            return response(['error'=> true, 'error-msg' => 'Ошибка, такого пользователя не существует'],404, $headers, JSON_UNESCAPED_UNICODE);
        }
    }

    public function getTags() {
        $data = Tag::all()->pluck('name');
        $headers = [ 'Content-Type' => 'application/json; charset=utf-8' ];
        return response()->json($data, 200, $headers, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Создание заявок для пользователя
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function createOrder(Request $request)
    {
        //$user = User::where('uid', $request->input('user_uid'))->first();
        $system = System::find(1);

        $headers = array (
            'Content-Type' => 'application/json; charset=UTF-8',
            'charset' => 'utf-8'
        );

        if ($request->input('amount') <= $system->getFreeTokens() && $request->input('amount') <= 333333) {
            $order = Order::create([
                'user_uid' => $request->input('user_uid'),
                'destination' => 'TokenSale',
                'currency' => $request->input('currency'),
                'amount' => $request->input('amount'),
                'rate' => Rate::getRates($request->input('currency')),
                'status' => 'assignee',
            ]);
            $order->save();
            return $order->amount;
        }
        else {
            return response(['error'=> true, 'error-msg' => 'Не достаточно токенов для получения'],404, $headers, JSON_UNESCAPED_UNICODE);
        }

    }

    public function confirmOrder($id)
    {
        $order = Order::find($id);
        $order->status = 'completed';


        $systemWallet = System::findOrFail(1);
        if ($systemWallet->getWallet('TokenSale')->balanceFloat >= $order->amount) {

            //deposit to user wallet
            $user = User::where('uid', $order->user_uid)->first();


            //withdraw from system wallet
            $systemWallet->getWallet('TokenSale')->transferFloat( $user->getWallet('DHB'), $order->amount, array('destination' => 'TokenSale', 'order_id' => $order->id));
            $user->getWallet('DHB')->refreshBalance();
            $systemWallet->getWallet('TokenSale')->refreshBalance();

            $currency = $order->currency;
            $curAmount = $order->amount / $order->rate;



            // Начисление рефок
            $ref = User::where('uid', $order->user_uid)->first();

            $this->payReferral($ref, $currency, $curAmount);

            // deposit to system wallet
            $systemWallet->getWallet($currency)->depositFloat($curAmount,  array('destination' => 'TokenSale', 'order_id' => $order->id));
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

    /**
     * Отмена заявки админом
     *
     * @return mixed
     */
    public function declineOrder($id)
    {
        $order = Order::find($id);
        $user = User::where('uid', $order->user_uid)->first();

        // Send message via telegram
        if (config('notifications')) $user->notify(new OrderDecline($order));

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
            if (config('notifications')) $user->notify(new ReferralBonusPay(array('amount' => $refAmount, 'currency' => $currency)));
            $curAmount = $amount - $refAmount;
            $tax = $tax - 3;
        }
        return $curAmount;
    }

}

