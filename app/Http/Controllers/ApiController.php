<?php

namespace App\Http\Controllers;

use App\Events\OrderAccepted;
use App\Events\OrderConfirmed;
use App\Helpers\ConfirmOrder;
use App\Helpers\Rate;
use App\Jobs\CheckTonTransactionStatusJob;
use App\Models\Currency;
use App\Models\Message;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\System;
use App\Models\UserConfig;
use App\Notifications\AcceptSendingByGate;
use App\Notifications\AcceptSendingByUser;
use App\Notifications\OrderAssignee;
use App\Notifications\OrderCreate;
use App\Notifications\OrderDecline;
use Bavix\Wallet\Models\Transaction;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;

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
     * @return ResponseFactory|Response
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
                }
                try {
                    $this->user->notify(new OrderCreate($order));
                } catch (CouldNotSendNotification $e) {
                    report ($e);
                }
                return response($order->id, 200);
            }
            else {
                return response(['error'=> true, 'message' => 'У вас уже есть активная заявка'],409, $this->headers, JSON_UNESCAPED_UNICODE);
            }
        else {
            return response(['error'=> true, 'message' => 'Не достаточно токенов для получения'],403, $this->headers, JSON_UNESCAPED_UNICODE);
        }

    }

    /**
     * Create self order by user
     * @param Request $request
     * @return Application|ResponseFactory|Response
     * @throws TelegramSDKException
     */
    public function createOrderByUser(Request $request) {

        $request->validate (
            [
                'destination'           => 'required',
                'currency'              => 'required',
                'payment'               => 'required',
                'amount'                => 'required|min:0|numeric|not_in:0',
            ],
            [
                'amount.required'       => 'Вы не ввели сумму',
                'amount.min'            => 'Сумма должна быть больше 0',
                'amount.not_in'         => 'Сумма должна быть больше 0',
                'amount.numeric'        => 'Введите корректную сумму',
                'destination.required'  => 'При создании заявки возникла ошибка',
                'currency.required'     => 'При создании заявки возникла ошибка',
                'payment.required'      => 'При создании заявки возникла ошибка',
            ]
        );

        if (!($this->user->hasActiveOrder() && $request->input('destination') != 'TokenSale') && !($this->user->hasActiveTokenSaleOrder() && $request->input('destination') == 'TokenSale')) {
            $error = false;

            $destination    = $request->input('destination');
            $amount         = $request->input('amount');
            $currency       = $request->input('currency');
            $payment        = $request->input('payment');
            $address        = $request->has('address') ? $request->input('address') : null;

            if ($destination == 'TokenSale') {
                $dhb_rate   = Rate::getRates('DHB');
                $dhb_amount = $request->input('dhb_amount');
                $amount     = $request->input('amount');
            } else {
                $dhb_rate   = '';
                $dhb_amount = '';
            }

            if ($destination == 'withdraw') {
                if ($this->user->getBalance($currency) < $amount) $error = 'Недостаточно средств для создания заявки';
            }

            if ($destination == 'withdraw' && $currency == 'DHB') {
                $error = 'Вывод DHB из системы невозможен';
            }

            if (!$error) {

                $order = Order::create([
                    'user_uid'          => $this->user->uid,
                    'destination'       => $destination,
                    'payment'           => $payment,
                    'currency'          => $currency,
                    'amount'            => $amount,
                    'status'            => 'created',
                    'rate'              => Rate::getRates($currency),
                    'payment_details'   => $address,
                    'dhb_rate'          => $dhb_rate,
                    'dhb_amount'        => $dhb_amount
                ]);

                $order->save();

                try {
                    $this->user->notify(new OrderCreate($order));
                } catch (CouldNotSendNotification $e) {
                    report ($e);
                }


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
                    $destination_message = ($destination == 'deposit' || $destination == 'TokenSale') ? '⬇️ Получение' : '⬆️ Отправление';
                    $inline_button = array(
                        "text" => "Принять заявку",
                        "url" => env('APP_URL') . '/wallet/orders/' . $order->id . '/accept'
                    );
                    $inline_keyboard = [[$inline_button]];
                    $keyboard = array("inline_keyboard" => $inline_keyboard);
                    $replyMarkup = json_encode($keyboard);
                    $message = '🔥 Новая заявка:  #' . $order->id;
                    if ($currency == 'TON') $message .= ' 💎';
                    $message .= PHP_EOL . '<b>'.$destination_message . ':  ' . $amount . ' ' . $currency.'</b>';
                    $message .= PHP_EOL;
                    if (Currency::where('title', $currency)->firstOrFail()->crypto) $message .= '🌐 Платежная сеть:  ' . $order->payment;
                    else $message .= '💳  <b>Платежная система: </b>  ' . $order->payment;

                    try {
                        $response = $telegram->sendMessage([
                            'chat_id' => env('TELEGRAM_GATE_ORDERS_CHAT_ID'),
                            'text' => $message,
                            'parse_mode' => 'html',
                            'reply_markup' => $replyMarkup
                        ]);
                        $text = $message;
                        // Сохраняем в базу все данные
                        $message = new Message();
                        $message->order_id = $order->id;
                        $message->message_id = $response['message_id'];
                        $message->message = $text;
                        $message->chat_id = env('TELEGRAM_GATE_ORDERS_CHAT_ID');
                        $message->save();

                    } catch (CouldNotSendNotification $e) {
                        report ($e);
                    }

                }


                return response($order->id, 200, $this->headers);
            } else return response(['error' => true, 'message' => $error], 404, $this->headers, JSON_UNESCAPED_UNICODE);
        }
        else {
            return response(['error' => true, 'message' => 'У вас уже есть активная заявка'], 403, $this->headers, JSON_UNESCAPED_UNICODE);
        }
    }


    /**
     * Подтверждение заявки пользователем, возможно устарела, протестировать и удалить
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function assigneeOrderByUser(Request $request)
    {
        $request->validate (
            [
                'id'            => 'required|numeric',
            ],
            [
                'id.required'   => 'Ошибка выполнения запроса',
                'id.numeric'    => 'Ошибка выполнения запроса',
            ]
        );

        $id = $request->input('id');
        $order = Order::where('id', $id)->where('user_uid', $this->user->uid)->firstOrFail();

        if ($order->status != 'completed') {

            $order->status = 'assignee';
            $order->save();

            try {
                $this->user->notify(new OrderAssignee($order));
            } catch (CouldNotSendNotification $e) {
                report ($e);
            }

            return $order->id;
        }
        else {
            return response(
                [
                    'error'     => true,
                    'message' => 'Вы пытаетесь подтвердить завершенную заявку'
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
        $request->validate (
            [
                'id'            => 'required|numeric',
            ],
            [
                'id.required'   => 'Ошибка выполнения запроса',
                'id.numeric'    => 'Ошибка выполнения запроса',
            ]
        );

        $id = $request->input('id');
        $order = Order::where('id', $id)->where('user_uid', $this->user->uid)->firstOrFail();

        if ($order->user_uid == $this->user->uid) {
            if ($order->status != 'completed') {

                try {
                    $this->user->notify(new OrderDecline($order));
                } catch (CouldNotSendNotification $e) {
                    report ($e);
                }

                $message = Message::where('order_id', $order->id)->first();
                if ($message) {
                    try {
                        $telegram = new Api(env('TELEGRAM_BOT_GATE_ORDERS_TOKEN'));
                        $telegram->editMessageText([
                            'chat_id' => $message->chat_id,
                            'message_id' => $message->message_id,
                            'text' => $message->message . PHP_EOL . '❌ <b>Заявка отменена пользователем</b>',
                            'parse_mode' => 'html',
                            'reply_markup' => NULL
                        ]);
                    } catch (TelegramSDKException $e) {
                        report ($e);
                    }
                }

                $order->forceDelete();
                return $order->id;
            }

            else abort(404);
        }
        else abort(404);
    }


    /**
     * @param Request $request
     * @return false|string
     */
    public function getTransactions(Request $request) {

        $request->validate (
            [
                'value'             => 'required',
            ],
            [
                'value.required'    => 'Ошибка выполнения запроса',
            ]
        );

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
     * @param Request $request
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
        $request->validate (
            [
                'value'             => 'required',
                'meta'              => 'required'
            ],
            [
                'value.required'    => 'Ошибка выполнения запроса',
                'meta.required'     => 'Ошибка выполнения запроса',
            ]
        );

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
     * @return JsonResponse
     */
    public function addPaymentDetails(Request $request): JsonResponse
    {
        $request->validate (
            [
                'payment'           => 'required',
                'address'           => 'required',
            ],
            [
                'payment.required'  => 'Ошибка выполнения запроса',
                'address.required'  => 'Ошибка выполнения запроса',
            ]
        );

        $title = $request->has('title') ? $request->input('title') : NULL;
        $payment = $request->input('payment');
        $holder = Payment::where('title', $payment)->firstOrFail()->currencies()->firstOrFail()->crypto ? null : $request->input('holder_name');

        $address = $request->input('address');
        $payment_details = PaymentDetail::create(
            [
                'user_uid'      => $this->user->uid,
                'payment_id'    => Payment::where('title', $payment)->firstOrFail()->id,
                'address'       => $address,
                'holder'        => $holder,
                'title'         => $title
            ],
        );
        $data[]       = [
            'title'     => $title,
            'user_uid'  => $this->user->uid,
            'payment'   => $payment,
            'address'   => $address,
            'holder'    => $holder,
            'id'        => $payment_details->id
        ];
        return response()->json($data);
    }

    /**
     * Редактирование реквизитов
     * @param Request $request
     * @return JsonResponse
     */
    public function editPaymentDetails(Request $request): JsonResponse
    {
        $paymentDetails = PaymentDetail::where('id', $request->input('id'))->where('user_uid', $this->user->uid)->firstOrFail();

        $title = $request->input('title') ? $request->input('title') : null;
        $address = $request->input('address');
        $holder = $request->input('holder_name') ? $request->input('holder_name') : null;

        $paymentDetails->title     = $title;
        $paymentDetails->address   = $address;
        $paymentDetails->holder   = $holder;
        $paymentDetails->save();

        return response()->json($paymentDetails);
    }

    /**
     * Удаление реквизитов
     * @param Request $request
     * @return JsonResponse
     */
    public function removePaymentDetails(Request $request): JsonResponse
    {
        $paymentDetails = PaymentDetail::where('id', $request->input('id'))->where('user_uid', $this->user->uid)->firstOrFail();
        if ($paymentDetails->user_uid == $this->user->uid) {
            $paymentDetails->forceDelete();
            return response()->json($paymentDetails);
        }
        else return response('У вас нет прав для этого действия', 404);
    }

    /**
     * Возвращаем реквизиты
     */
    public function getPaymentDetails()
    {
        return $this->user->paymentDetails()->with('payment')->get()->toJson();
    }


    /**
     * Подтверждение заявки шлюзом
     * @param Request $request
     * @return void | integer $order->id
     * @throws Exception
     */
    public function acceptOrderByGate(Request $request)
    {
        if ($this->user->isGate()) {
            $order = Order::where('id', $request->input('id'))->firstOrFail();
            $error = false;
            if ($order->destination == 'withdraw' && $this->user->getWallet($order->currency.'_gate')->balanceFloat < $order->amount) $error = true;
            if ($order->status != 'created') $error = true;
            if (!$error) {
                if ($order->destination == 'deposit' || $order->destination == 'TokenSale') {
                    $order->payment_details = $request->input('payment_details');
                }
                $order->gate = $this->user->uid;
                if ($order->currency == 'TON') {
                    $order->comment = $this->generateUniqueCode();
                }
                $order->status = 'accepted';
                $order->save();

                // Вызов хелпера OrderAccepted
                new \App\Helpers\AcceptOrder($order);

                if ($order->currency == 'TON') {
                    // Вызов задания CheckTonTransactionStatus
                    dispatch(new CheckTonTransactionStatusJob($order));
                }
                return $order->id;
            }
            else return response('У вас нет прав для этого действия', 404);
        }
        else return response('У вас нет прав для этого действия', 404);
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
                    try {
                        $owner->notify(new AcceptSendingByGate($order));
                    } catch (CouldNotSendNotification $e) {
                        report ($e);
                    }
                    return $order->id;
                }
            }
        }
        else return response('У вас нет прав для этого действия', 404);
    }


    /**
     * Подтверждение отправки средств пользователем
     * @param Request $request
     * @return void | integer $order->id
     */
    public function acceptSendingByUser(Request $request)
    {
        $order = Order::where('id', $request->input('id'))->firstOrFail();
        if ($this->user->uid == $order->user_uid) {
            if ($order->status == 'accepted') {
                $order->status = 'pending';
                $gate = $order->gate()->first();
                $order->save();
                try {
                    $gate->notify(new AcceptSendingByUser($order));
                } catch (CouldNotSendNotification $e) {
                    report ($e);
                }
                return $order->id;
            }
        }
        else return response('У вас нет прав для этого действия', 404);
    }

    /**
     * Подтверждение поступления средств шлюзом
     * @param Request $request
     * @return Application|ResponseFactory|Response
     * @throws TelegramSDKException
     */
    public function confirmOrderByGate(Request $request)
    {
        $order = Order::where('id', $request->input('id'))->firstOrFail();
        if ($order->status == 'accepted' || $order->status == 'pending') {

            if ($order->gate == $this->user->uid) {
                return new ConfirmOrder($order);
            }
            else response(['error' => true, 'message' => 'У вас нет прав на выполнение этой заявки'], 404, $this->headers, JSON_UNESCAPED_UNICODE);

        }
        return response(['error'=>true, 'message' => 'Заявка не может быть выполнена'], 404, $this->headers, JSON_UNESCAPED_UNICODE);
    }


    /**
     * Подтверждение заявки пользователем
     * @param Request $request
     * @return Application|ResponseFactory|Response|void
     */
    public function confirmOrderByUser(Request $request)
    {
        $order = Order::where('id', $request->input('id'))->firstOrFail();
        $gate = User::where('uid', $order->gate)->first();

        if ($order->user_uid == $this->user->uid) {
            if (($gate->getWallet($order->currency.'_gate')->balanceFloat >= $order->amount)) {
                $transaction = $this->user->getWallet($order->currency)->withdrawFloat($order->amount, array('destination' => 'withdraw from wallet'));
                $this->user->getWallet($order->currency)->refreshBalance();
                $gate->getWallet($order->currency.'_gate')->withdrawFloat($order->amount, array('destination' => 'withdraw from gate wallet'));
                $order->status = 'completed';
                $order->transaction()->attach($transaction->id);
                $order->save();
                // Бонус за успешное выполнение задания
                $systemWallet = System::findOrFail(1);
                $tax = round($order->amount * Rate::getRates($order->currency) / 200 / Rate::getRates('DHB'));
                $systemWallet->getWallet('DHBFundWallet')->transferFloat( $gate->getWallet('DHB'), $tax, array('destination' => 'Бонус за успешное выполнение заявки', 'order_id' => $order->id));
                $systemWallet->getWallet('DHBFundWallet')->refreshBalance();
                $gate->getWallet('DHB')->refreshBalance();

                return $order->id;
            }
            else response(['error'=>true, 'message' => 'Недостаточно баланса'], 404, $this->headers, JSON_UNESCAPED_UNICODE);
        }
        else {
            return response(['error'=>true, 'message' => 'У вас нет прав на эту операцию'], 404, $this->headers, JSON_UNESCAPED_UNICODE);
        }
    }


    /**
     * Метод отмены заявки шлюзом, пока не используется
     * @param Request $request
     * @return bool|Application|ResponseFactory|Response
     */
    public function declineOrderByGate(Request $request)
    {
        $id = $request->input('id');
        if ($this->user->isGate()) {
            $order = Order::where('id', $id)->where('gate', $this->user->uid)->first();
            $owner = User::where('uid', $order->user_uid)->first();

            // Send message via telegram
            try {
                $owner->notify(new OrderDecline($order));
            } catch (CouldNotSendNotification $e) {
                report ($e);
            }

            $message = Message::where('order_id', $order->id)->first();
            if ($message) {
                try {
                    $telegram = new Api(env('TELEGRAM_BOT_GATE_ORDERS_TOKEN'));
                    $telegram->editMessageText([
                        'chat_id' => $message->chat_id,
                        'message_id' => $message->message_id,
                        'text' => $message->message . PHP_EOL . '❌ <b>Заявка отменена шлюзом</b>',
                        'parse_mode' => 'html',
                        'reply_markup' => NULL
                    ]);
                } catch (TelegramSDKException $e) {
                    report ($e);
                }
            }

            $order->forceDelete();
            return true;
        }
        else return response(['error'=>true, 'message' => 'У вас нет прав на эту операцию'], 404, $this->headers, JSON_UNESCAPED_UNICODE);

    }


    /**
     * Фильтрация пользовательских заявок
     * @param Request $request
     * @return mixed \App\Models\Order
     */
    public function getOrdersByFilter(Request $request): mixed
    {
        $filter = $request->input('filter');
        switch ($filter) {
            case'deposit':
                return $this->user->orders()->OrdersDeposit()->limit(10)->orderBy('id', 'DESC')->get();
                break;
            case'withdraw':
                return $this->user->orders()->OrdersWithdraw()->limit(10)->orderBy('id', 'DESC')->get();
                break;
            case'all':
                return $this->user->orders()->limit(10)->orderBy('id', 'DESC')->get();
                break;
        }
    }


    /**
     * Перевод средств между пользователями
     * @param Request $request
     * @return bool|Application|ResponseFactory|Response
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
        else return response(['error' => true, 'message' => 'Не достаточно баланса'], 404, $this->headers, JSON_UNESCAPED_UNICODE);
    }

    public function getVisibleWallets() {
        return json_decode(UserConfig::firstOrCreate(
            ['user_uid' => Auth::user()->uid, 'meta' => 'visible_wallets'],
            ['value' => json_encode(['DHB', 'BTC', 'ETH'])]
        )->value, true);
    }

    /**
     * Write code on Method
     *
     * @return integer
     * @throws Exception
     */
    public function generateUniqueCode(): int
    {
        do {
            $code = random_int(100000, 999999);
        } while (Order::where("status", "!=", 'completed')->where('comment', '=', $code)->first());

        return $code;
    }
}
