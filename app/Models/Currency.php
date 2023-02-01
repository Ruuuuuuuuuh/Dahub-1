<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


/**
 * Модель для валют / токенов
 * @method static where(string $string, mixed $currency)
 * @method static payableCurrencies()
 */
class Currency extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Получить все платежные сети выбранной валюты
     * @return BelongsToMany
     */
    public function payments(): BelongsToMany
    {
        return $this->belongsToMany(
            Payment::class,
            'currencies_payments',
            'currency_id',
            'payment_id'
        );
    }


    /**
     * Возвращает список доступных валют
     * @param $query
     * @return mixed
     */
    public function scopePayableCurrencies($query)
    {
        return $query->where('title', '!=', 'HFT')->where('visible', '1');
    }

}
