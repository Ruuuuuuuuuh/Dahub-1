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
        if ($currency == 'USDT' || $currency == 'USD') {
            return 1;
        }
        elseif ($currency == 'DHB') {
            return $system->rate;
        }
        elseif ($currency == 'RUB') {
            return 0.014;
        }
        else {
            if (!Cache::get($currency)) {
                $response = Http::get('https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest?symbol=' . $currency . '&convert=USD&CMC_PRO_API_KEY=96fc9b4e-ab30-4d60-b0fb-23c9da6456b6');
                static::Cache($currency, $response->json()["data"][$currency]["quote"]["USD"]["price"]);
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
