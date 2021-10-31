<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, mixed $payment)
 */
class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'crypto',
    ];

    public function currencies()
    {
        //return $this->belongsToMany(RelatedModel, pivot_table_name, foreign_key_of_current_model_in_pivot_table, foreign_key_of_other_model_in_pivot_table);
        return $this->belongsToMany(
            Currency::class,
            'currencies_payments',
            'payment_id',
            'currency_id');
    }
}
