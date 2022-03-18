<?php

namespace App\Models;

use Bavix\Wallet\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



/**
 * @method static create(array $array)
 * @method static where(string $string, mixed $id)
 * @method static findOrFail($id)
 */
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
        'payment',
        'payment_details',
        'tax',
        'dhb_rate',
        'dhb_amount'
    ];

    /**
     * Получить пользователей заявки.
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'user_uid', 'uid');
    }

    /**
     * Получить шлюза
     */
    public function gate(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'gate', 'uid');
    }

    public function payment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Payment', 'title', 'title');
    }

    public function paymentDetails(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\PaymentDetail', 'payment_details', 'id');
    }

    public function transactions()
    {
        return \Bavix\Wallet\Models\Transaction::where('type', 'deposit')->where('meta', 'like', '%"order_id": ' . $this->getKey() . '%')->get();
    }

    public function orderSystemTransaction()
    {
        return \Bavix\Wallet\Models\Transaction::where('type', 'withdraw')->where('meta', 'like', '%"order_id": ' . $this->getKey() . '%')->where('payable_type', 'App\Models\System')->first();
    }

    public function transaction(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Transaction::class, 'order_transaction', 'order_id', 'transaction_id');
    }

    public function scopeNotCompleted($query)
    {
        return $query->where('status', '!=', 'completed')->where('destination', '=', 'TokenSale');
    }

    public function scopeUserOrders($query)
    {
        return $query->where('destination', '=', 'deposit')->orWhere('destination', '=', 'withdraw')->orderBy('id', 'DESC');
    }

    public function scopeOrdersDeposit($query)
    {
        return $query->where('destination', '=', 'deposit')->orWhere('destination', '=', 'TokenSale')->orderBy('id', 'DESC');
    }

    public function scopeOrdersWithdraw($query)
    {
        return $query->where('destination', '=', 'withdraw')->orderBy('id', 'DESC');
    }

}

