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
use NotificationChannels\Telegram\Exceptions\CouldNotSendNotification;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;

class ExplorerMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new job instance.
     *
     * @param  Order $order
     * @return void
     */
    public function __construct(Order $order)
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
        $system = System::first();
        try {

            $telegram = new Api(env('TELEGRAM_BOT_EXPLORER_TOKEN'));
            $system->getWallet('TokenSale')->refreshBalance();
            $transaction = $system->transactions()->where('meta', 'like', '%"order_id": ' . $this->order->id . '%')->first();

            $telegram->sendMessage([
                'chat_id' => env('TELEGRAM_EXPLORER_CHAT_ID'),
                'text' => '<b>🆕 Transaction created</b> ' . $transaction->created_at->format('d.m.Y H:i') . PHP_EOL . '<b>↗️ Sent: </b>' . $this->order->amount . ' ' . $this->order->currency . PHP_EOL . '<b>↙️ Recieved: </b>' . $this->order->dhb_amount . ' DHB' . PHP_EOL . '<b>#️⃣ Hash: </b>' . $transaction->uuid . PHP_EOL . PHP_EOL . '<b>🔥 TokenSale: </b>' . number_format($system->getWallet('TokenSale')->balanceFloat, 0, '.', ' ') . ' DHB left until the end of stage 1',
                'parse_mode' => 'html'
            ]);
        } catch (CouldNotSendNotification $e) {
            report($e);
        }
    }
}
