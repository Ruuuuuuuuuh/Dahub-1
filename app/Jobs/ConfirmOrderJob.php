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
    public function __construct(\App\Models\Order $order)
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
        $owner = \App\Models\User::where('uid', $this->order->user_uid)->first();
        $gate  = \App\Models\User::where('uid', $this->order->gate)->first();
        if ($this->order != 'completed') {
            if ($this->order->destination == 'deposit') {
                $transaction = $owner->getWallet($this->order->currency)->depositFloat($this->order->amount, array('destination' => 'deposit to wallet'));
                $owner->getWallet($this->order->currency)->refreshBalance();
                $this->order->status = 'completed';
                $this->order->transaction()->attach($transaction->id);
                $this->order->save();

            }
            if ($this->order->destination == 'TokenSale') {
                $systemWallet = \App\Models\System::findOrFail(1);
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
                dispatch(new \App\Jobs\PayReferralJob($owner, $this->order->currency, $this->order->amount));

                // ConfirmedNotificationsJob
                dispatch(new \App\Jobs\ExplorerMessageJob($this->order));

                // Бонус за успешное выполнение задания
                $systemWallet->getWallet('DHBFundWallet')->transferFloat( $gate->getWallet('DHB'), $this->order->dhb_amount / 200, array('destination' => 'Бонус за успешное выполнение заявки', 'order_id' => $this->order->id));
                $systemWallet->getWallet('DHBFundWallet')->refreshBalance();
                $gate->getWallet('DHB')->refreshBalance();

            }

            // ConfirmedNotificationsJob
            dispatch(new \App\Jobs\ConfirmedNotificationsJob($this->order));

            $gate->getBalance($this->order->currency.'_gate');
            $gate->getWallet($this->order->currency.'_gate')->depositFloat($this->order->amount, array('destination' => 'deposit to wallet', 'order_id' => $this->order->id));
            $gate->getWallet($this->order->currency.'_gate')->refreshBalance();
        }

    }
}
