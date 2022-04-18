<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use NotificationChannels\Telegram\Exceptions\CouldNotSendNotification;
use Telegram\Bot\Exceptions\TelegramSDKException;

class AcceptedNotificationsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    /**
     * Модель текущей заявки
     *
     * @var Order
     */
    protected $order;

    /**
     * Create a new job instance.
     *
     * @param  Order $order
     * @return void
     */
    public function __construct(\App\Models\Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws TelegramSDKException
     */
    public function handle()
    {
        if ($this->order->status != 'completed') {
            $owner = \App\Models\User::where('uid', $this->order->user_uid)->first();
            if ($this->order->destination == 'deposit' || $this->order->destination == 'TokenSale') {
                try {
                    $owner->notify(new \App\Notifications\AcceptDepositOrder($this->order));
                } catch (CouldNotSendNotification $e) {
                    report ($e);
                    $this->release(5);
                }
            }
            elseif ($this->order->destination == 'withdraw' && $this->order->status != 'completed') {
                try {
                    $owner->notify(new \App\Notifications\AcceptWithdrawOrder($this->order));
                } catch (CouldNotSendNotification $e) {
                    report ($e);
                    $this->release(5);
                }
            }

            $message = \App\Models\Message::where('order_id', $this->order->id)->first();
            if ($message) {
                $telegram = new \Telegram\Bot\Api(env('TELEGRAM_BOT_GATE_ORDERS_TOKEN'));
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
                    $this->release(5);
                }
            }
        }
    }
}
