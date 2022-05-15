<?php

namespace App\Traits;

use App\Models\Currency as Currency;

/**
 * @method hasWallet($currency)
 * @method getWallet($currency)
 * @method createWallet(array $array)
 */
trait GetBalance
{
    public function getBalance($currency): float
    {
        if (!$this->hasWallet($currency)) {
            $this->createWallet(
                [
                    'name' => $currency,
                    'slug' => $currency,
                    'decimal_places' => Currency::where('title', str_replace('_gate', '', $currency))->first()->decimal_places
                ]
            );
        }
        $this->getWallet($currency)->refreshBalance();
        return $this->getWallet($currency)->balanceFloat;
    }
}
