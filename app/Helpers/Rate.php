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
            return \App\Models\Rate::where('title', 'DHB')->orderBy('created_at', 'desc')->first()->value;
        }

        elseif ($currency == 'RUB') {
            if (!Cache::get($currency)) {
                $response = Http::retry(3, 100)->get('https://www.cbr.ru/scripts/XML_daily.asp');
                $json = json_decode(json_encode(simplexml_load_string($response->body())));
                foreach ($json->Valute as $index => $value) {
                    if ($value->CharCode == 'USD') {
                        static::Cache($currency, 1 / intval($value->Value));
                        return Cache::get($currency);
                    }
                }
            }
            else return Cache::get($currency);
        }

        else {
            if (!Cache::get($currency)) {
                $response = Http::retry(3, 100)->get('https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest?symbol=' . $currency . '&convert=USD&CMC_PRO_API_KEY=96fc9b4e-ab30-4d60-b0fb-23c9da6456b6');
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
