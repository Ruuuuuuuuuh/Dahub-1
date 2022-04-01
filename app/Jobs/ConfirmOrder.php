<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\System;
use App\Models\User;
use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ConfirmOrder implements ShouldQueue
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
        if ($this->order->destination == 'deposit') {
            $transaction = $owner->getWallet($this->order->currency)->depositFloat($this->order->amount, array('destination' => 'deposit to wallet'));
            $owner->getWallet($this->order->currency)->refreshBalance();
            $this->order->status = 'completed';
            $this->order->transaction()->attach($transaction->id);
            $this->order->save();
        }
        if ($this->order->destination == 'TokenSale') {
            $systemWallet = System::findOrFail(1);
            $systemWallet->getWallet('TokenSale')->transferFloat( $owner->getWallet('DHB'), $this->order->dhb_amount, array('destination' => 'TokenSale', 'order_id' => $this->order->id));
            $owner->getWallet('DHB')->refreshBalance();

            // pay Referral
            dispatch(new PayReferral($owner, $this->order->currency, $this->order->amount));

            // deposit to system wallet
            $systemWallet->getWallet($this->order->currency)->depositFloat($this->order->amount,  array('destination' => 'TokenSale', 'order_id' => $this->order->id));
            $systemWallet->getWallet($this->order->currency)->refreshBalance();

            $this->order->status = 'completed';
            $this->order->save();

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
