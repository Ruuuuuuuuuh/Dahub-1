<?php

namespace App\Models;

use Bavix\Wallet\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_uid',
        'destination',
        'currency',
        'amount',
        'status',
        'rate',
    ];

    /**
     * Получить пользователей заявки.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_uid', 'uid');
    }

    public function transactions()
    {
        return Transaction::where('type', 'deposit')->where('meta', 'like', '%"order_id": ' . $this->getKey() . '%')->get();
    }

    public function scopeNotCompleted($query)
    {
        return $query->where('status', '!=', 'completed');
    }

}
