<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\ReferralBonusPay;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use NotificationChannels\Telegram\Exceptions\CouldNotSendNotification;

class PayReferralJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $currency;
    protected $amount;

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @param $currency
     * @param $amount
     * @return float|int
     */
    public function __construct(User $user, $currency, $amount)
    {
        $this->user         = $user;
        $this->currency     = $currency;
        $this->amount       = $amount;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tax = 9; // Процент на первом уровне
        while ($this->user->referred_by && $tax > 0) {
            $this->user = User::where('affiliate_id', $this->user->referred_by)->first();
            $refAmount = ($this->amount * $tax ) / 100;
            $this->user->getWallet($this->currency)->depositFloat($refAmount, array('destination' => 'referral'));
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
