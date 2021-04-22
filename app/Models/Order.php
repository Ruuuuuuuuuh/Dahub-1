<?php

namespace App\Models;

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

    public function scopeNotCompleted($query)
    {
        return $query->where('status', '!=', 'completed');
    }

}
