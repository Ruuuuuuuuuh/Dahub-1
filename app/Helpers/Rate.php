<?php

namespace App\Helpers;
use App\Models\System;
use Cache;
use Illuminate\Support\Facades\Http;

/**
 * Класс для получения курса валют
 * Class Rate
 * @package App\Helpers
 */
class Rate
{

    /**
     * @param string $currency
     * @return integer
     */
    public static function getRates(string $currency)
    {
        $system = System::find(1);
        // Курс
        if ($currency == 'USDT') {
            return 1 / $system->rate;
        }
        else {
            if (!Cache::get($currency)) {
                $response = Http::get('https://api.coinbase.com/v2/prices/'.$currency.'-USD/spot');
                static::Cache($currency, $response->json()["data"]["amount"] * (1 / $system->rate));
                return Cache::get($currency);
            }
            else return Cache::get($currency);
        }
    }


    /**
     * @param $name
     * @param $value
     * @param $limit
     */
    public static function Cache($name, $value, $limit = 900) {
        if (!Cache::has($name)) {
            Cache::put($name, $value, $limit);
        }
    }
}
