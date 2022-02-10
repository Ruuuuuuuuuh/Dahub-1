<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, mixed $currency)
 */
class Currency extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function payments()
    {
        //return $this->belongsToMany(RelatedModel, pivot_table_name, foreign_key_of_current_model_in_pivot_table, foreign_key_of_other_model_in_pivot_table);
        return $this->belongsToMany(
            Payment::class,
            'currencies_payments',
            'currency_id',
            'payment_id');
    }


    public function scopePayableCurrencies($query)
    {
        return $query->where('title', '!=', 'HFT')->where('visible', '1');
    }
}
