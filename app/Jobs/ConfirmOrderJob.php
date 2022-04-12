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

class ConfirmOrderJob implements ShouldQueue
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
     */
    public function handle()
    {
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
                dispatch(new PayReferralJob($owner, $this->order->currency, $this->order->amount));

                // ConfirmedNotificationsJob
                dispatch(new ConfirmedNotificationsJob($this->order));

                $systemWallet = System::findOrFail(1);
                try {

                    $telegram = new Api(env('TELEGRAM_BOT_EXPLORER_TOKEN'));
                    $systemWallet->getWallet('TokenSale')->refreshBalance();
                    $transaction = $systemWallet->transactions()->where('meta', 'like', '%"order_id": ' . $this->order->id . '%')->first();

                    $telegram->sendMessage([
                        'chat_id' => env('TELEGRAM_EXPLORER_CHAT_ID'),
                        'text' => '<b>🆕 Transaction created</b> ' . $transaction->created_at->format('d.m.Y H:i') .PHP_EOL.'<b>↗️ Sent: </b>' . $this->order->amount . ' ' . $this->order->currency .PHP_EOL.'<b>↙️ Recieved: </b>' . $this->order->dhb_amount . ' DHB' .PHP_EOL.'<b>#️⃣ Hash: </b>' . $transaction->uuid. PHP_EOL.PHP_EOL.'<b>🔥 TokenSale: </b>'. number_format($systemWallet->getWallet('TokenSale')->balanceFloat, 0, '.', ' ') . ' DHB left until the end of stage 1',
                        'parse_mode' => 'html'
                    ]);
                } catch (CouldNotSendNotification $e) {
                    report ($e);
                }

                // Бонус за успешное выполнение задания
                $systemWallet->getWallet('DHBFundWallet')->transferFloat( $gate->getWallet('DHB'), $this->order->dhb_amount / 200, array('destination' => 'Бонус за успешное выполнение заявки', 'order_id' => $this->order->id));
                $systemWallet->getWallet('DHBFundWallet')->refreshBalance();
                $gate->getWallet('DHB')->refreshBalance();

            }

            $gate->getBalance($this->order->currency.'_gate');
            $gate->getWallet($this->order->currency.'_gate')->depositFloat($this->order->amount, array('destination' => 'deposit to wallet', 'order_id' => $this->order->id));
            $gate->getWallet($this->order->currency.'_gate')->refreshBalance();
        }

    }
}
