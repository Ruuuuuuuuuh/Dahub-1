<?php

namespace App\Models;

use App\Helpers\Rate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\User as User;
use App\Models\System as System;




class Gate extends User
{
    protected $table = 'users';


    /**
     * Функция для получения баланса шлюза
     * @param $currency
     * @param int $decimal
     * @return float
     */
    public function getBalance($currency, $decimal = 2): float
    {
        $currencyGate = $currency.'_gate';
        if (!$this->hasWallet($currencyGate)) {
            $this->createWallet(
                [
                    'name' => $currencyGate,
                    'slug' => $currencyGate,
                    'decimal_places' => System::findOrFail(1)->getWallet($currency)->decimal_places
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
