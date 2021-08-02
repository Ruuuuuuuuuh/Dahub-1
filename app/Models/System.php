<?php

namespace App\Models;

use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Interfaces\WalletFloat;
use Bavix\Wallet\Traits\HasWalletFloat;
use Bavix\Wallet\Traits\HasWallets;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Questocat\Referral\Traits\UserReferral;

class System extends Model implements Wallet, WalletFloat
{
    use HasFactory, Notifiable, HasWallets, UserReferral, HasWalletFloat;

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
        $balance = 2000000 - $this->getWallet('TokenSale')->balanceFloat;
        return $balance;
    }

    /**
     * @return int
     * Сумма доступных токенов
     */
    public function getFreeTokens()
    {
        return $this->getWallet('TokenSale')->balanceFloat - $this->getSoldTokens() - $this->getFrozenTokens();
    }

    /**
     * @return int
     * Сумма доступных токенов для продажи
     */
    public function getAvailableTokens()
    {
        if ($this->getFreeTokens() >= 333333) return 333333; else return $this->getFreeTokens();
    }

    public function getTransactions($type)
    {
        return $this->transactions()->where('type', $type)->orderBy('id', 'DESC');
    }
}
