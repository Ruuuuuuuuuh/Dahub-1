<?php

namespace App\Helpers;
use App\Models\Message;
use App\Models\Order;
use App\Models\User;
use App\Notifications\AcceptDepositOrder;
use App\Notifications\AcceptWithdrawOrder;
use NotificationChannels\Telegram\Exceptions\CouldNotSendNotification;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;


class AcceptOrder
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
     * @return void
     * @throws TelegramSDKException
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
        if ($this->order->status != 'completed') {
            $this->notify();
        }
    }

    /**
     * Notifications Method
     * @throws TelegramSDKException
     */
    public function notify() {

        $owner = User::where('uid', $this->order->user_uid)->first();
        if ($this->order->destination == 'deposit' || $this->order->destination == 'TokenSale') {
            try {
                $owner->notify(new AcceptDepositOrder($this->order));
            } catch (CouldNotSendNotification $e) {
                report ($e);
            }
        }
        elseif ($this->order->destination == 'withdraw' && $this->order->status != 'completed') {
            try {
                $owner->notify(new AcceptWithdrawOrder($this->order));
            } catch (CouldNotSendNotification $e) {
                report ($e);
            }
        }

        $message = Message::where('order_id', $this->order->id)->first();
        if ($message) {
            $telegram = new Api(env('TELEGRAM_BOT_GATE_ORDERS_TOKEN'));
            try {
                $telegram->editMessageText([
                    'chat_id' => $message->chat_id,
                    'message_id' => $message->message_id,
                    'text' => $message->message . PHP_EOL . '✅ <b>Заявка принята шлюзом</b>',
                    'parse_mode' => 'html',
                    'reply_markup' => NULL
                ]);
            } catch (TelegramSDKException $e) {
                report ($e);
            }
        }

    }
}
