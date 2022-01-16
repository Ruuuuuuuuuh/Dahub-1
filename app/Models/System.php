<?php

namespace App\Models;

use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Interfaces\WalletFloat;
use Bavix\Wallet\Traits\HasWalletFloat;
use Bavix\Wallet\Traits\HasWallets;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Notifications\Notifiable;
use Questocat\Referral\Traits\UserReferral;



/**
 * @method static findOrFail(int $int)
 * @method static find(int $int)
 */
class System extends Model implements Wallet, WalletFloat
{
    use HasFactory, Notifiable, HasWallets, UserReferral, HasWalletFloat;

    /**
     * @return float
     * Сумма замороженных токенов
     */
    public function getFrozenTokens(): float
    {
        $orders = Order::where('status', '!=', 'completed')->get();
        $frozenTokens = 0;
        foreach ($orders as $order) {
            $frozenTokens += $order->amount;
        }
        return $frozenTokens;
    }

    /**
     * Сумма проданных токенов
     * @return float
     */
    public function getSoldTokens(): float
    {
        return 2000000 - $this->getWallet('TokenSale')->balanceFloat;
    }

    /**
     * Сумма доступных токенов
     * @return float
     */
    public function getFreeTokens() : float
    {
        return $this->getWallet('TokenSale')->balanceFloat - $this->getSoldTokens() - $this->getFrozenTokens();
    }

    /**
     * Сумма доступных токенов для продажи
     * @return float
     */
    public function getAvailableTokens() : float
    {
        if ($this->getFreeTokens() >= 333333) return 333333; else return $this->getFreeTokens();
    }

    /**
     * @param $type
     * @return MorphMany
     */
    public function getTransactions($type): MorphMany
    {
        return $this->transactions()->where('type', $type)->orderBy('id', 'DESC');
    }
}
