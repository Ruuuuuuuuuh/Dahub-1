<?php


namespace App\Http\Controllers;

use App\Helpers\Rate;
use App\Models\Currency;
use App\Models\Payment;
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
use Telegram\Bot\Api;

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
        $system->getWallet('DHBFundWallet')->refreshBalance();
        $system->getWallet('DHBFundWallet')->transferFloat( $system->getWallet('TokenSale'), 2000000, array('destination' => 'StartTokenSale'));
        return true;
    }

    /**
     * Установка курса DHB/USDT.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return boolean
     */
    public function setDHBRate(Request $request): bool
    {
        $rate = new \App\Models\Rate();
        $rate->title = 'DHB';
        $rate->value = $request->input('rate');
        $rate->save();
        return true;
    }

    public function setDHBPerUser(Request $request): bool
    {
        $system = System::findOrFail(1);
        $system->amount_per_user = $request->input('amount');
        $system->save();
        return true;
    }

    public function setDHBPerOrder(Request $request): bool
    {
        $system = System::findOrFail(1);
        $system->amount_per_order = $request->input('amount');
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
        $destinations = explode(',', $destination );
        $message = '';
        if ( $request->has('message')) $message = $request->input('message');
        foreach ($destinations as $destination) {
            if (!Tag::where('name', $destination)->exists()) {
                $tag = new Tag;
                $tag->name = $destination;
                $tag->save();
            }
        }

        $systemWallet = System::findOrFail(1);
        $systemWallet->getWallet($currency)->withdrawFloat($amount, array('destination' => $destinations, 'comment' => $message));
        return true;
    }

    public function sendTokens(Request $request)
    {

        $amount = $request->input('amount');
        $currency = $request->input('currency');
        $message = '';
        if ( $request->has('message')) $message = $request->input('message');
        $destinations = false;
        if ($request->has('destination')) {
            $destination = $request->input('destination');
            $destinations = explode(',', $destination );
        }

        $username = $request->input('username');
        $user = User::where('uid', $username)->first();
        if ($user) {
            if ($destinations) {
                foreach ($destinations as $destination) {
                    if (!Tag::where('name', $destination)->exists()) {
                        $tag = new Tag;
                        $tag->name = $destination;
                        $tag->save();
                    }
                }
            }
            if (!$user->getWallet($currency)) {
                $user->createWallet(
                    [
                        'name' => $currency,
                        'slug' => $currency,
                    ]
                );
            }
            $systemWallet = System::findOrFail(1);
            if ($currency == 'DHBFundWallet') {
                $systemWallet->getWallet($currency)->transferFloat($user->getWallet('DHB'), $amount, array('destination' => $destinations, 'comment' => $message));
            }
            else {
                $systemWallet->getWallet($currency)->transferFloat($user->getWallet($currency), $amount, array('destination' => $destinations, 'comment' => $message));
                $systemWallet->getWallet($currency)->refreshBalance();
                if ($currency == 'HFT') {
                    $telegram = new Api(env('TELEGRAM_BOT_HARVEST_TOKEN'));
                    $transaction = $user->getWallet('HFT')->transactions()->orderBy('id', 'desc')->first();
                    $response = $telegram->sendMessage([
                        'chat_id' => env('TELEGRAM_HARVEST_CHAT_ID'),
                        'text' => '<b>🆕 Transaction created</b> ' . $transaction->created_at->format('d.m.Y H:i') .PHP_EOL.'<b>➡️ Transfer: </b>' . $amount . ' HFT '  .PHP_EOL.'<b>#️⃣ Hash: </b>' . $transaction->uuid.PHP_EOL.PHP_EOL.'There is still ' .$systemWallet->getWallet('HFT')->balanceFloat. ' HFT in the main wallet.',
                        'parse_mode' => 'html'
                    ]);
                }
            }

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

        if ($request->input('amount') >= 2000 && $request->input('amount') <= 333333) {
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

        $headers = array (
            'Content-Type' => 'application/json; charset=UTF-8',
            'charset' => 'utf-8'
        );

        if ($order->status != 'completed' && $order->gate ==  null)
        {
            $systemWallet = System::findOrFail(1);
            $order->gate = Auth::user()->uid;
            $order->save();
            if ($systemWallet->getWallet('TokenSale')->balanceFloat >= $order->amount) {

                //deposit to user wallet
                $user = User::where('uid', $order->user_uid)->first();


                //withdraw from system wallet
                $systemWallet->getWallet('TokenSale')->transferFloat( $user->getWallet('DHB'), $order->amount, array('destination' => 'TokenSale', 'order_id' => $order->id));
                $user->getWallet('DHB')->refreshBalance();
                $systemWallet->getWallet('TokenSale')->refreshBalance();

                $currency = $order->currency;
                $curAmount = $systemWallet->rate * $order->amount / $order->rate;



                // Начисление рефок
                $ref = User::where('uid', $order->user_uid)->first();

                $this->payReferral($ref, $currency, $curAmount);

                // deposit to system wallet
                $systemWallet->getWallet($currency)->depositFloat($curAmount,  array('destination' => 'TokenSale', 'order_id' => $order->id));
                $systemWallet->getWallet($currency)->refreshBalance();

                $order->status = 'completed';
                // сохраняем модель
                $order->save();

                $telegram = new Api(env('TELEGRAM_BOT_EXPLORER_TOKEN'));
                $transactions = $order->transactions();
                foreach ($transactions as $transaction) {
                    if ($transaction->payable_type == 'App\Models\System') {
                        $systemWallet->getWallet('TokenSale')->refreshBalance();
                        $response = $telegram->sendMessage([
                            'chat_id' => env('TELEGRAM_EXPLORER_CHAT_ID'),
                            'text' => '<b>🆕 Transaction created</b> ' . $transaction->created_at->format('d.m.Y H:i') .PHP_EOL.'<b>↗️ Sent: </b>' . $curAmount . ' ' . $currency .PHP_EOL.'<b>↙️ Recieved: </b>' . $order->amount . ' DHB' .PHP_EOL.'<b>#️⃣ Hash: </b>' . $transaction->uuid. PHP_EOL.PHP_EOL.'<b>🔥 TokenSale: </b>'. number_format($systemWallet->getWallet('TokenSale')->balanceFloat, 0, '.', ' ') . ' DHB left until the end of stage 1',
                            'parse_mode' => 'html'
                        ]);
                    }
                }
                return $order->id;
            }
            else {
                return response(['error'=>true, 'error-msg' => 'Баланс системы меньше запрашиваемой суммы'], 404, $headers, JSON_UNESCAPED_UNICODE);
            }
        }
        else return response(['error'=>true, 'error-msg' => 'Заявка выполнена'], 404, $headers, JSON_UNESCAPED_UNICODE);

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

    public function setHFT(Request $request)
    {
        $amount = $request->input('amount');
        $system = System::findOrFail(1);
        $system->getWallet('HFT')->refreshBalance();
        $system->getWallet('HFT')->depositFloat($amount, array('destination' => 'Начисление HFT'));
        $telegram = new Api(env('TELEGRAM_BOT_HARVEST_TOKEN'));
        $transaction = $system->getWallet('HFT')->transactions()->orderBy('id', 'desc')->first();
        $response = $telegram->sendMessage([
            'chat_id' => env('TELEGRAM_HARVEST_CHAT_ID'),
            'text' => '<b>🆕 Transaction created</b> ' . $transaction->created_at->format('d.m.Y H:i') .PHP_EOL.'<b>⬇️ Created: </b>' . $amount . ' HFT '  .PHP_EOL.'<b>#️⃣ Hash: </b>' . $transaction->uuid,
            'parse_mode' => 'html'
        ]);
        return 'success';
    }

    public function addCurrency(Request $request)
    {
        $title = $request->input('title');
        if ($request->has('crypto')) {
            $crypto = $request->input('crypto');
        }
        else $crypto = false;

        if ($request->has('decimal_places')) {
            $decimal_places = $request->input('decimal_places');
        }
        else $decimal_places = 0;

        Currency::firstOrCreate([
            'title' => $title,
            'crypto' => $crypto,
            'decimal_places' => $decimal_places
        ]);
        $system = System::findOrFail(1);
        if (!$system->getWallet($title)) {
            $system->createWallet(
                [
                    'name' => $title,
                    'slug' => $title,
                ]
            );
        }
        $system->getWallet($title)->refreshBalance();
        return 'success';
    }

    public function addPayment(Request $request)
    {
        $title = $request->input('title');
        if ($request->has('crypto')) {
            $crypto = $request->input('crypto');
        }
        else $crypto = false;

        Payment::firstOrCreate([
            'title' => $title,
            'crypto' => $crypto
        ]);

        return 'success';
    }

    public function attachPaymentToCurrency(Request $request)
    {
        $currency = $request->input('currency');
        $payment = $request->input('payment');
        $currency = Currency::where('title', $currency)->first();
        $currency->payments()->attach(Payment::where('title', $payment)->first()->id);

        return 'success';
    }

}

