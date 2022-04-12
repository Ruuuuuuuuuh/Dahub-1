<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\System;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use NotificationChannels\Telegram\Exceptions\CouldNotSendNotification;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;

class ExplorerNotificationsJob implements ShouldQueue
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
     */
    protected $order;

    /**
     * Create a new job instance.
     *
     * @param $id
     */
    public function __construct($id)
    {
        $this->order = Order::firstOrFail($id);
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws TelegramSDKException
     */
    public function handle()
    {
        /*$owner = User::where('uid', $this->order->user_uid)->first();
        if ($this->order->status == 'completed') {

            $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));

            try {
                $systemWallet = System::findOrFail(1);
                $systemWallet->getWallet('TokenSale')->refreshBalance();
                $transaction = $systemWallet->transactions()->where('meta', 'like', '%"order_id": ' . $this->order->id . '%')->first();

                Log::info('Transaction', [$transaction]);

                $telegram->sendMessage([
                    'chat_id' => $owner->uid,
                    'text' => '<b>🆕 Transaction created</b> ' . $transaction->created_at->format('d.m.Y H:i') .PHP_EOL.'<b>↗️ Sent: </b>' . $this->order->amount . ' ' . $this->order->currency .PHP_EOL.'<b>↙️ Recieved: </b>' . $this->order->dhb_amount . ' DHB' .PHP_EOL.'<b>#️⃣ Hash: </b>' . $transaction->uuid. PHP_EOL.PHP_EOL.'<b>🔥 TokenSale: </b>'. number_format($systemWallet->getWallet('TokenSale')->balanceFloat, 0, '.', ' ') . ' DHB left until the end of stage 1',
                    'parse_mode' => 'html'
                ]);
            } catch (CouldNotSendNotification $e) {
                report ($e);
            }
        }
        else $this->release(10);*/
    }
}
