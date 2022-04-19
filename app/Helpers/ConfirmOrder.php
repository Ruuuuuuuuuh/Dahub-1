<?php

namespace App\Helpers;
use App\Models\Message;
use App\Models\Order;
use App\Models\System;
use App\Models\User;
use NotificationChannels\Telegram\Exceptions\CouldNotSendNotification;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\FileUpload\InputFile;


class ConfirmOrder
{
    /**
     * Модель текущей заявки
     *
     * @var Order
     */
    protected Order $order;

    /**
     * Create a new job instance.
     *
     * @param Order $order
     * @throws TelegramSDKException
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
        $owner = User::where('uid', $this->order->user_uid)->first();
        $gate  = User::where('uid', $this->order->gate)->first();
        if ($this->order != 'completed') {
            if ($this->order->destination == 'deposit') {
                $transaction = $owner->getWallet($this->order->currency)->depositFloat($this->order->amount, array('destination' => 'deposit to wallet'));
                $owner->getWallet($this->order->currency)->refreshBalance();
                $this->order->status = 'completed';
                $this->order->transaction()->attach($transaction->id);
                $this->order->save();
            }
            if ($this->order->destination == 'TokenSale') {
                $systemWallet = System::findOrFail(1);
                $transaction = $systemWallet->getWallet('TokenSale')->transferFloat( $owner->getWallet('DHB'), $this->order->dhb_amount, array('destination' => 'TokenSale', 'order_id' => $this->order->id));

                $owner->getWallet('DHB')->refreshBalance();
                $wID = $transaction->withdraw_id;
                $this->order->transaction()->attach($wID);

                // deposit to system wallet
                $systemWallet->getWallet($this->order->currency)->depositFloat($this->order->amount,  array('destination' => 'TokenSale', 'order_id' => $this->order->id));
                $systemWallet->getWallet($this->order->currency)->refreshBalance();
                $this->order->status = 'completed';
                $this->order->save();

                // pay Referral
                new \App\Helpers\PayReferral($owner, $this->order->currency, $this->order->amount);

                // ConfirmedNotificationsJob
                new \App\Helpers\ExplorerMessage($this->order);

                // Бонус за успешное выполнение задания
                $systemWallet->getWallet('DHBFundWallet')->transferFloat( $gate->getWallet('DHB'), $this->order->dhb_amount / 200, array('destination' => 'Бонус за успешное выполнение заявки', 'order_id' => $this->order->id));
                $systemWallet->getWallet('DHBFundWallet')->refreshBalance();
                $gate->getWallet('DHB')->refreshBalance();

            }

            try {
                $owner->notify(new \App\Notifications\ConfirmOrder($this->order));
            } catch (CouldNotSendNotification $e) {
                report ($e);
            }

            $message = Message::where('order_id', $this->order->id)->first();
            if ($message) {
                try {
                    $telegram = new Api(env('TELEGRAM_BOT_GATE_ORDERS_TOKEN'));
                    $telegram->editMessageText([
                        'chat_id' => $message->chat_id,
                        'message_id' => $message->message_id,
                        'text' => $message->message . PHP_EOL . '🏁 <b>Заявка выполнена</b>',
                        'parse_mode' => 'html',
                        'reply_markup' => NULL
                    ]);
                } catch (TelegramSDKException $e) {
                    report ($e);
                }
            }

            if ($this->order->destination == 'TokenSale') {
                // Отправка сообщения, если пользователь впервые купил токены
                if ($owner->orders()->where('status', 'completed')->where('destination', 'TokenSale')->get()->count() == 1) {
                    try {
                        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
                        $telegram->sendPhoto([
                            'chat_id' => $owner->uid,
                            'photo' => InputFile::create(env('APP_URL')."/img/welcome.png"),
                            'caption' =>
                                '<b>На связи команда проекта DAHUB!</b>'
                                . PHP_EOL .
                                'Присоединяйся в наши паблики, чат и поддержку, чтобы всегда быть в курсе событий и иметь доступ ко всем материалам проекта.'
                                . PHP_EOL . PHP_EOL .
                                '⭐ <a href="https://t.me/DaHubBot">DAHUB Bot</a> – главный бот проекта. Авторизация на платформе, оповещения о заявках и их статусе. Рекомендуем поставить его в закреп для быстрого доступа к платформе и кошельку.'
                                . PHP_EOL .
                                '🕶 <a href="https://t.me/+Uydxy_Jmh-3Y_BUg">DAHUB for owners of DHB</a> – закрытый чат и информация для держателей DHB'
                                . PHP_EOL .
                                '📣 <a href="https://t.me/DA_HUB">DAHUB News</a> – новости проекта'
                                . PHP_EOL .
                                '🔍 <a href="https://t.me/DaHubExplorer">DAHUB Explorer</a> – обозреватель транзакций на платформе'
                                . PHP_EOL .
                                '💬 <a href="https://t.me/DaHubSupportBot?start=public">DaHubSupportBot</a> – служба поддержки проекта. По всем вопрос сюда;)'
                                . PHP_EOL . PHP_EOL .
                                'Мы за дружественную коммуникацию, пиши, задавай вопросы, делись инсайтами. Добро пожаловать в DAHUB DAO!',
                            'parse_mode' => 'html',
                        ]);
                    }
                    catch (CouldNotSendNotification $e) {
                        report ($e);
                    }
                }
            }

            $gate->getBalance($this->order->currency.'_gate');
            $gate->getWallet($this->order->currency.'_gate')->depositFloat($this->order->amount, array('destination' => 'deposit to wallet', 'order_id' => $this->order->id));
            $gate->getWallet($this->order->currency.'_gate')->refreshBalance();
        }

        return $this->order->id;
    }

    /**
     * Notifications Method
     */
    public function notify() {

    }
}
