<?php

namespace App\Http\Controllers;

use App\Helpers\Rate;
use App\Models\Currency;
use App\Models\Gate;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\System;
use App\Models\UserConfig;
use App\Notifications\AcceptDepositOrder;
use App\Notifications\AcceptSendingByGate;
use App\Notifications\AcceptWithdrawOrder;
use App\Notifications\AdminNotifications;
use App\Notifications\ConfirmOrder;
use App\Notifications\OrderAssignee;
use App\Notifications\OrderCreate;
use App\Notifications\OrderDecline;
use App\Notifications\ReferralBonusPay;
use Bavix\Wallet\Models\Transaction;
use http\Client\Response;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\Api;

class ApiController extends Controller
{
    /**
     *
     * Экземпляр класса авторизованного пользователь
     * @var Auth::user()
     */
    protected $user;

    /**
     * Заголовки запроса
     * @var array
     */
    protected $headers;


    /**
     * Конструктор, присваиваем приватные свойства
     */
    public function __construct() {

        $this->middleware(function ($request, $next) {

            $this->user = Auth::user();

            $this->headers = array (
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            );

            return $next($request);
        });
    }

    /**
     * Create Order from users
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function createOrder(Request $request)
    {
        if ($request->input('amount') >= 2000 && $request->input('amount') <= 333333)
            if (!empty($this->user->orders()->notCompleted()->get())) {
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
                    $message = 'Новая заявка ' . $order->id . ' на покупку ' . $order->amount . ' DHB. [Написать пользователю](tg://user?id='.$this->user->uid.')';
                    if (config('notifications')) $admin->notify(new AdminNotifications($message));
                }
                if (config('notifications')) $this->user->notify(new OrderCreate($order));
                return response($order->id, 200);
            }
            else {
                return response(['error'=> true, 'error-msg' => 'У вас уже есть активная заявка'],404, $this->headers, JSON_UNESCAPED_UNICODE);
            }
        else {
            return response(['error'=> true, 'error-msg' => 'Не достаточно токенов для получения'],404, $this->headers, JSON_UNESCAPED_UNICODE);
        }

    }

    /**
     * Create self order by user
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function createOrderByUser(Request $request) {

        $request->validate (
            [
                'amount' => 'required|min:0|numeric',
            ],
            [
                'amount.required' => 'Вы не ввели сумму',
                'amount.min' => 'Сумма должна быть больше 0',
                'amount.numeric' => 'Введите корректную сумму',
            ]
        );

        if (!$this->user->hasActiveOrder()) {
            $error = false;

            $destination = $request->input('destination');
            $amount = $request->input('amount');
            $currency = $request->input('currency');
            $payment = $request->input('payment');

            if ($destination == 'TokenSale') {
                $dhb_rate = Rate::getRates('DHB');
                $dhb_amount = $request->input('dhb_amount');
                $amount = $request->input('amount');
            } else {
                $dhb_rate = '';
                $dhb_amount = '';
            }

            if ($destination == 'withdraw') {
                if ($this->user->getBalance($currency) < $amount) $error = 'Недостаточно средств для создания заявки';
            }

            if (!($request->has('amount') && $request->input('amount') != null)) {
                $error = 'Вы не ввели сумму';
            }

            if (!$error) {
                $address = $destination == 'deposit' ? null : $request->input('address');

                $order = Order::create([
                    'user_uid' => $this->user->uid,
                    'destination' => $destination,
                    'payment' => $payment,
                    'currency' => $currency,
                    'amount' => $amount,
                    'status' => 'created',
                    'rate' => Rate::getRates($currency),
                    'payment_details' => $address,
                    'dhb_rate' => $dhb_rate,
                    'dhb_amount' => $dhb_amount
                ]);
                $order->save();

                $this->user->notify(new OrderCreate($order));

                // Добавление валюты в список валют на главном экране
                $visibleWallets = $this->getVisibleWallets();
                if (!in_array($currency, $visibleWallets)) {
                    $visibleWallets[] = $currency;
                    UserConfig::updateOrCreate(
                        ['user_uid' => $this->user->uid, 'meta' => 'visible_wallets'],
                        ['value' => $visibleWallets]
                    );
                }

                // Отправление сообщения боту в паблик шлюзов
                if (env('TELEGRAM_BOT_GATE_ORDERS_TOKEN') !== null && env('TELEGRAM_BOT_GATE_ORDERS_TOKEN') !== '') {
                    $telegram = new Api(env('TELEGRAM_BOT_GATE_ORDERS_TOKEN'));
                    $destination_message = ($destination == 'deposit' || $destination == 'TokenSale') ? 'получение' : 'отправление';
                    $inline_button = array(
                        "text" => "Принять заявку",
                        "url" => env('APP_URL') . '/dashboard/orders/' . $order->id . '/accept'
                    );
                    $inline_keyboard = [[$inline_button]];
                    $keyboard = array("inline_keyboard" => $inline_keyboard);
                    $replyMarkup = json_encode($keyboard);
                    $message = '🔥 <b>Новая заявка: </b> #' . $order->id . ' на ' . $destination_message . ' ' . $amount . ' ' . $currency;
                    if ($currency == 'TON') $message .= ' 💎';
                    $message .= PHP_EOL;
                    if (Currency::where('title', $currency)->firstOrFail()->crypto) $message .= '🌐 <b>Платежная сеть: </b> ' . $order->payment;
                    else $message .= '💳  <b>Платежная система: </b> ' . $order->payment;
                    $telegram->sendMessage([
                        'chat_id' => env('TELEGRAM_GATE_ORDERS_CHAT_ID'),
                        'text' => $message,
                        'parse_mode' => 'html',
                        'reply_markup' => $replyMarkup
                    ]);
                }


                return response($order->id, 200, $this->headers);
            } else return response(['error' => true, 'error-msg' => $error], 404, $this->headers, JSON_UNESCAPED_UNICODE);
        }
        else {
            return response(['error' => true, 'error-msg' => 'У вас уже есть активная заявка'], 404, $this->headers, JSON_UNESCAPED_UNICODE);
        }
    }


    /**
     * Подтверждение заявки пользователем, возможно устарела, протестировать и удалить
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function assigneeOrderByUser(Request $request)
    {
        $id = $request->input('id');
        $order = Order::where('id', $id)->where('user_uid', $this->user->uid)->first();

        if ($order->status != 'completed') {
            if (config('notifications')) $this->user->notify(new OrderAssignee($order));
            $order->status = 'assignee';
            $order->save();
            return $order->id;
        }
        else {
            return response(
                [
                    'error'     => true,
                    'error-msg' => 'Вы пытаетесь подтвердить завершенную заявку'
                ],
                404,
                $this->headers,
                JSON_UNESCAPED_UNICODE
            );
        }
    }


    /**
     * Отмена заявки пользовтелем
     *
     * @return mixed
     */
    public function declineOrderByUser(Request $request)
    {
        $id = $request->input('id');
        $order = Order::where('id', $id)->where('user_uid', $this->user->uid)->first();
        if ($order->status != 'completed') {
            if ($order->status != 'created') {
                $gate = User::where('uid', $order->gate)->first();
                $gate->unfreezeTokens($order->currency, $order->amount);
            }
            // Send message via telegram
            if (config('notifications')) $this->user->notify(new OrderDecline($order));

            $order->forceDelete();
            return $order->id;
        }

        else abort(404);

    }


    /**
     * @param \Illuminate\Http\Request $request
     * @return false|string
     */
    public function getTransactions(Request $request) {
        $value = $request->input('value');
        $user = User::where('uid', $value)->first();
        if ($user) {
            $ordersList = array();
            $i = 0;
            foreach ($user->orders()->get() as $order) {
                $ordersList[$i]['currency'] = $order->currency;
                $ordersList[$i]['amount'] = $order->amount;
                $ordersList[$i]['dhb_amount'] = $order->dhb_amount;
                $transaction = $order->orderSystemTransaction();
                $ordersList[$i]['date'] = $transaction->created_at->diffForHumans() . ', ' . $transaction->created_at->Format('H:s');
                $ordersList[$i]['uuid'] = $transaction->uuid;
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
            $orderList[0]['dhb_amount'] = $order->dhb_amount;
            $orderList[0]['date'] = $transaction->created_at->diffForHumans() . ', ' . $transaction->created_at->Format('H:s');
            $orderList[0]['uuid'] = $value;
            return json_encode($orderList, JSON_FORCE_OBJECT | JSON_NUMERIC_CHECK);
        }
    }


    /**
     * Получить платежные сети привязанные к валюте
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
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
            ['user_uid' => $this->user->uid, 'meta' => $meta],
            ['value' => $value]
        );
        return true;
    }


    /**
     * Получение юзер конфига
     * @param $meta
     * @return string
     */
    public function getUserConfig($meta): string
    {
        return UserConfig::where('user_uid', '=',  $this->user->uid)->where('meta', '=', $meta)->first();
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addPaymentDetails(Request $request): \Illuminate\Http\JsonResponse
    {
        $payment = $request->input('payment');
        $holder = Payment::where('title', $payment)->firstOrFail()->currencies()->firstOrFail()->crypto ? $request->input('holder_name') : null;
        $address = $request->input('address');
        $payment_details = PaymentDetail::create(
            [
                'user_uid' => $this->user->uid,
                'payment_id' => Payment::where('title', $payment)->firstOrFail()->id,
                'address' => $address,
                'holder' => $holder,
            ],
        );
        $data[]       = [
            'user_uid' => $this->user->uid,
            'payment' => $payment,
            'address' => $address,
            'holder' => $holder,
            'id'    => $payment_details->id
        ];
        return response()->json($data);
    }


    /**
     * Возвращаем реквизиты
     * @return PaymentDetail
     */
    public function getPaymentDetails(): PaymentDetail
    {
        return $this->user->paymentDetails()->with('payment');
    }


    /**
     * Подтверждение заявки шлюзом
     * @param Request $request
     * @return void | integer $order->id
     */
    public function acceptOrderByGate(Request $request)
    {
        if ($this->user->isGate()) {
            $order = Order::where('id', $request->input('id'))->firstOrFail();
            if ($order->status == 'created' && $this->user->getBalanceFree($order->currency) >= $order->amount) {
                $order->gate = $this->user->uid;
                $owner = User::where('uid', $order->user_uid)->first();
                if ($order->destination == 'deposit' || $order->destination == 'TokenSale') {
                    $this->user->freezeTokens($order->currency, $order->amount);
                    $order->payment_details = $request->input('payment_details');
                    $owner->notify(new AcceptDepositOrder($order));
                }
                else {
                    $owner->notify(new AcceptWithdrawOrder($order));
                }
                $order->status = 'accepted';
                $order->save();
                return $order->id;
            }
        }
        else abort(404);
    }


    /**
     * Подтверждение отправки шлюзом
     * @param Request $request
     * @return void | integer $order->id
     */
    public function acceptSendingByGate(Request $request)
    {
        if ($this->user->isGate()) {
            $order = Order::where('id', $request->input('id'))->firstOrFail();
            if ($order->status == 'accepted' && $order->gate == $this->user->uid) {
                $owner = User::where('uid', $order->user_uid)->first();
                if ($order->destination == 'withdraw') {
                    $order->status = 'pending';
                    $order->save();
                    $owner->notify(new AcceptSendingByGate($order));
                    return $order->id;
                }
            }
        }
        else abort(404);
    }


    /**
     * Подтверждение поступления средств шлюзом
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function confirmOrderByGate(Request $request)
    {
        $order = Order::where('id', $request->input('id'))->firstOrFail();
        if ($order->status == 'accepted') {
            $owner = $order->user()->first();

            if ($order->gate == $this->user->uid) {
                if (($this->user->getBalanceFree($order->currency) > $order->amount)) {
                    if ($order->destination == 'deposit') {
                        $transaction = $owner->getWallet($order->currency)->depositFloat($order->amount, array('destination' => 'deposit to wallet'));
                        $owner->getWallet($order->currency)->refreshBalance();
                        $order->status = 'completed';
                        $order->transaction()->attach($transaction->id);
                        $order->save();
                    }
                    if ($order->destination == 'TokenSale') {
                        $systemWallet = System::findOrFail(1);
                        $systemWallet->getWallet('TokenSale')->transferFloat( $owner->getWallet('DHB'), $order->dhb_amount, array('destination' => 'TokenSale', 'order_id' => $order->id));
                        $owner->getWallet('DHB')->refreshBalance();

                        // pay Referral
                        $this->payReferral($owner, $order->currency, $order->amount);

                        // deposit to system wallet
                        $systemWallet->getWallet($order->currency)->depositFloat($order->amount,  array('destination' => 'TokenSale', 'order_id' => $order->id));
                        $systemWallet->getWallet($order->currency)->refreshBalance();

                        $order->status = 'completed';
                        $owner->depositInner($order->currency, $order->amount);
                        $telegram = new Api(env('TELEGRAM_BOT_EXPLORER_TOKEN'));
                        $transactions = $order->transactions();
                        $order->save();

                        foreach ($transactions as $transaction) {
                            if ($transaction->payable_type == 'App\Models\System' && $transaction->type = 'withdraw') {
                                $order->transaction()->attach($transaction->id);
                                $systemWallet->getWallet('TokenSale')->refreshBalance();
                                $telegram->sendMessage([
                                    'chat_id' => env('TELEGRAM_EXPLORER_CHAT_ID'),
                                    'text' => '<b>🆕 Transaction created</b> ' . $transaction->created_at->format('d.m.Y H:i') .PHP_EOL.'<b>↗️ Sent: </b>' . $order->amount . ' ' . $order->currency .PHP_EOL.'<b>↙️ Recieved: </b>' . $order->dhb_amount . ' DHB' .PHP_EOL.'<b>#️⃣ Hash: </b>' . $transaction->uuid. PHP_EOL.PHP_EOL.'<b>🔥 TokenSale: </b>'. number_format($systemWallet->getWallet('TokenSale')->balanceFloat, 0, '.', ' ') . ' DHB left until the end of stage 1',
                                    'parse_mode' => 'html'
                                ]);
                            }
                        }
                        // Бонус за успешное выполнение задания
                        $systemWallet->getWallet('DHBFundWallet')->transferFloat( $this->user->getWallet('DHB'), $order->dhb_amount / 200, array('destination' => 'Бонус за успешное выполнение заявки', 'order_id' => $order->id));
                        $systemWallet->getWallet('DHBFundWallet')->refreshBalance();
                        $this->user->getWallet('DHB')->refreshBalance();

                    }

                    $this->user->getBalance($order->currency.'_gate');
                    $this->user->getWallet($order->currency.'_gate')->depositFloat($order->amount, array('destination' => 'deposit to wallet', 'order_id' => $order->id));
                    $this->user->getWallet($order->currency.'_gate')->refreshBalance();

                    $owner->notify(new ConfirmOrder($order));

                    // Отправка сообщения, если пользователь впервые купил токены
                    $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
                    if ($owner->orders()->where('status', 'completed')->where('destination', 'TokenSale')->get()->count() == 1) {
                        try {
                            $telegram->sendPhoto([
                                'chat_id' => $owner->uid,
                                'photo' => \Telegram\Bot\FileUpload\InputFile::create("https://test.dahub.app/img/welcome.png"),
                                'caption' =>
                                    '<b>На связи команда проекта DaHub!</b>'
                                    . PHP_EOL .
                                    'Присоединяйся в наши паблики, чат и поддержку, чтобы всегда быть в курсе событий и иметь доступ ко всем материалам проекта.'
                                    . PHP_EOL . PHP_EOL .
                                    '▪️ <a href="https://t.me/+Uydxy_Jmh-3Y_BUg">Dahub for owners of DHB</a> – закрытый чат и информация для держателей DHB'
                                    . PHP_EOL .
                                    '▪️ <a href="https://t.me/DA_HUB">Dahub News</a> – новости проекта'
                                    . PHP_EOL .
                                    '▪️ <a href="https://t.me/DaHubExplorer">Dahub Explorer</a> – обозреватель транзакций на платформе'
                                    . PHP_EOL .
                                    '▪️ <a href="https://t.me/DaHubSupportBot?start=public">DaHubSupportBot</a> – служба поддержки проекта. По всем вопрос сюда;)'
                                    . PHP_EOL . PHP_EOL .
                                    'Мы за дружественную коммуникацию, пиши, задавай вопросы, делись инсайтами. Добро пожаловать в DaHub DAO!',
                                'parse_mode' => 'html',
                            ]);
                        }
                        catch (TelegramResponseException $e) {

                        }
                    }

                    return $order->id;
                }
                else return response(['error' => true, 'error-msg' => 'Недостаточно баланса'], 404, $this->headers, JSON_UNESCAPED_UNICODE);
            }
            else {
                return response(['error'=>true, 'error-msg' => 'У вас нет прав на эту операцию'], 404, $this->headers, JSON_UNESCAPED_UNICODE);
            }


        }
        return response(['error'=>true, 'error-msg' => 'Заявка не может быть выполнена'], 404, $this->headers, JSON_UNESCAPED_UNICODE);
    }


    /**
     * Подтверждение заявки пользователем
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|void
     */
    public function confirmOrderByUser(Request $request)
    {
        $order = Order::where('id', $request->input('id'))->firstOrFail();
        $gate = User::where('uid', $order->gate)->first();

        if ($order->user_uid == $this->user->uid) {
            if (($gate->getBalanceFree($order->currency) > $order->amount)) {
                $transaction = $this->user->getWallet($order->currency)->withdrawFloat($order->amount, array('destination' => 'withdraw from wallet'));
                $this->user->getWallet($order->currency)->refreshBalance();
                $gate->unfreezeTokens($order->currency, $order->amount);
                $gate->getWallet($order->currency.'_gate')->withdrawFloat($order->amount, array('destination' => 'withdraw from gate wallet'));
                $order->status = 'completed';
                $order->transaction()->attach($transaction->id);
                $order->save();
                return $order->id;
            }
            else response(['error'=>true, 'error-msg' => 'Недостаточно баланса'], 404, $this->headers, JSON_UNESCAPED_UNICODE);
        }
        else {
            return response(['error'=>true, 'error-msg' => 'У вас нет прав на эту операцию'], 404, $this->headers, JSON_UNESCAPED_UNICODE);
        }
    }


    /**
     * Метод отмены заявки шлюзом, пока не используется
     * @param \Illuminate\Http\Request $request
     * @return bool|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function declineOrderByGate(Request $request)
    {
        $id = $request->input('id');
        if ($this->user->isGate()) {
            $order = Order::where('id', $id)->where('gate', $this->user->uid)->first();
            $owner = User::where('uid', $order->user_uid)->first();

            // Send message via telegram
            if (config('notifications')) $owner->notify(new OrderDecline($order));
            $order->forceDelete();
            return true;
        }
        else return response(['error'=>true, 'error-msg' => 'У вас нет прав на эту операцию'], 404, $this->headers, JSON_UNESCAPED_UNICODE);

    }


    /**
     * Фильтрация пользовательских заявок
     * @param \Illuminate\Http\Request $request
     * @return mixed \App\Models\Order
     */
    public function getOrdersByFilter(Request $request)
    {
        $filter = $request->input('filter');
        switch ($filter) {
            case'deposit':
                return $this->user->orders()->OrdersDeposit()->limit(10)->get();
                break;
            case'withdraw':
                return $this->user->orders()->OrdersWithdraw()->limit(10)->get();
                break;
            case'all':
                return $this->user->orders()->UserOrders()->limit(10)->get();
                break;
        }
    }


    /**
     * Перевод средств между пользователями
     * @param \Illuminate\Http\Request $request
     * @return bool|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function transfer(Request $request) {

        $amount = $request->input('amount');
        $currency = $request->input('currency');
        $username = $request->input('username');

        if ($this->user->getBalanceFree($currency) >= $amount) {
            if ($username != 'DHBFundWallet') {
                $receiver = User::where('uid', $username)->firstOrFail();
                $this->user->getWallet($currency)->transferFloat($receiver->getWallet($currency), $amount, array('destination' => 'Transfer from user'));
                $this->user->getWallet($currency)->refreshBalance();
                $receiver->getWallet($currency)->refreshBalance();
            }
            else {
                $this->user->getWallet($currency)->transferFloat(System::findOrFail(1)->getWallet('DHBFundWallet'), $amount, array('destination' => 'Transfer from user'));
            }
            return true;
        }
        else return response(['error' => true, 'error-msg' => 'Не достаточно баланса'], 404, $this->headers, JSON_UNESCAPED_UNICODE);
    }


    /**
     * @param User $user
     * @param $currency
     * @param $amount
     * @return float|int
     */
    public function payReferral(User $user, $currency, $amount) {

        $tax = 9; // Процент на первом уровне
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

    public function getVisibleWallets() {
        return json_decode(UserConfig::firstOrCreate(
            ['user_uid' => Auth::user()->uid, 'meta' => 'visible_wallets'],
            ['value' => json_encode(['DHB', 'BTC', 'ETH'])]
        )->value, true);
    }
}
