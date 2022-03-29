<?php

namespace App\Listeners;

use App\Events\OrderAccepted;
use App\Models\Message;
use App\Models\User;
use App\Notifications\AcceptDepositOrder;
use App\Notifications\AcceptWithdrawOrder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;

class SendAcceptedNotifications implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param OrderAccepted $event
     * @return void
     * @throws TelegramSDKException
     */
    public function handle(OrderAccepted $event)
    {
        $owner = User::where('uid', $event->order->user_uid)->first();
        if ($event->order->destination == 'deposit' || $event->order->destination == 'TokenSale') {
            try {
                $owner->notify(new AcceptDepositOrder($event->order));
            } catch (CouldNotSendNotification $e) {
                report ($e);
            }
        }
        else {
            try {
                $owner->notify(new AcceptWithdrawOrder($event->order));
            } catch (CouldNotSendNotification $e) {
                report ($e);
            }
        }

        $message = Message::where('order_id', $event->order->id)->first();
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
