<?php

namespace App\Models;

use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Traits\HasWallet;
use Bavix\Wallet\Traits\HasWallets;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Questocat\Referral\Traits\UserReferral;

class System extends Model implements Wallet
{
    use HasFactory, Notifiable, HasWallet, HasWallets, UserReferral;

    /**
     * @return int
     * Сумма замороженных токенов
     */
    public function getFrozenTokens() {
        $orders = Order::where('status', '!=', 'completed')->get();
        $frozenTokens = 0;
        foreach ($orders as $order) {
            $frozenTokens += $order->amount;
        }
        return $frozenTokens;
    }


    /**
     * @return int
     * Сумма проданных токенов
     */
    public function getSoldTokens()
    {
        $balance = 0;
        $users = User::all();
        foreach ($users as $user) {
            $balance += $user->getWallet('DHB')->balance;
        }
        return $balance;
    }

    /**
     * @return int
     * Сумма доступных токенов для продажи
     */
    public function getFreeTokens()
    {
        return $this->getWallet('DHB')->balance - $this->getSoldTokens() - $this->getFrozenTokens();
    }
}
