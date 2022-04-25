<?php

namespace App\Helpers;
use App\Models\System;
use App\Models\User;
use App\Notifications\ReferralBonusPay;
use NotificationChannels\Telegram\Exceptions\CouldNotSendNotification;


class PayReferral
{
    protected User $user;
    protected string $currency;
    protected float $amount;

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @param $currency
     * @param $amount
     * @return void
     */
    public function __construct(User $user, $currency, $amount)
    {
        $this->user         = $user;
        $this->currency     = $currency;
        $this->amount       = $amount;

        $tax = 9; // Процент на первом уровне
        $system = System::first();
        while ($this->user->referred_by && $tax > 0) {
            $this->user = User::where('affiliate_id', $this->user->referred_by)->first();
            $refAmount = ($this->amount * $tax ) / 100;
            $system->getWallet($this->currency)->transferFloat($this->user->getWallet($this->currency), $refAmount, array('destination' => 'referral'));
            $system->getWallet($this->currency)->refreshBalance();
            $this->user->getWallet($this->currency)->refreshBalance();

            try {
                $this->user->notify(new ReferralBonusPay(array('amount' => $refAmount, 'currency' => $this->currency)));
            } catch (CouldNotSendNotification $e) {
                report ($e);
            }
            $tax = $tax - 3;
        }
    }
}
