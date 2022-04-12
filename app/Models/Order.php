<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @method static create(array $array)
 * @method static where(string $string, mixed $id)
 * @method static findOrFail($id)
 * @method static orderBy(string $string, string $string1)
 * @method static firstOrFail($id)
 * @property mixed $id
 * @property mixed $payment_details
 * @property mixed $user_uid
 * @property mixed $amount
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property mixed $destination
 * @property mixed $dhb_amount
 * @property mixed $gate
 * @property mixed $currency
 * @property mixed|string $status
 * @property mixed $payment
 * @property mixed $comment
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
        'dhb_amount',
        'comment'
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
        return \Bavix\Wallet\Models\Transaction::where('meta', 'like', '%"order_id": ' . $this->getKey() . '%')->where('meta', 'like', '%TokenSale%')->get();
    }

    public function orderSystemTransaction()
    {
        return \Bavix\Wallet\Models\Transaction::where('type', 'withdraw')->where('meta', 'like', '%"order_id": ' . $this->getKey() . '%')->where('payable_type', 'App\Models\System')->first();
    }

    public function transaction(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\Bavix\Wallet\Models\Transaction::class, 'order_transaction', 'order_id', 'transaction_id');
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

