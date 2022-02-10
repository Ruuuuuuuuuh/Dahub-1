<?php

namespace App\Models;

use App\Helpers\Rate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User as User;
use App\Models\System as System;

use Bavix\Wallet\Interfaces\WalletFloat;
use Bavix\Wallet\Models\Transaction;
use Bavix\Wallet\Traits\HasWalletFloat;
use Illuminate\Notifications\Notifiable;
use Bavix\Wallet\Traits\HasWallets;
use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Interfaces\Confirmable;
use Bavix\Wallet\Traits\CanConfirm;
use Questocat\Referral\Traits\UserReferral;


class Gate extends User implements Wallet, Confirmable, WalletFloat
{
    use HasFactory, Notifiable, HasWallets, UserReferral, CanConfirm, Notifiable, HasWalletFloat;

    protected $table = 'users';


    /**
     * Функция для получения баланса шлюза
     * @param $currency
     * @param int $decimal
     * @return float
     */
    public function getBalance($currency, int $decimal = 2): float
    {
        $currencyGate = $currency.'_gate';
        if (!$this->hasWallet($currencyGate)) {
            $this->createWallet(
                [
                    'name' => $currencyGate,
                    'slug' => $currencyGate,
                    'decimal_places' => Currency::where('title', $currency)->first()->decimal_places
                ]
            );
        }
        return $this->getWallet($currencyGate)->balanceFloat;
    }

    /**
     * Доступный баланс для приема средств
     * @param $currency
     * @param $amount
     * @return float|int
     */
    public function availableBalance($currency, $amount) : float
    {
        return $this->getBalanceFree() * $amount / Rate::getRates($currency);
    }

}
