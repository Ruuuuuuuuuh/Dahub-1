<?php

namespace App\Models;

use App\Helpers\Rate;
use App\Traits\GetBalance;
use Bavix\Wallet\Interfaces\WalletFloat;
use Bavix\Wallet\Traits\HasWalletFloat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Bavix\Wallet\Traits\HasWallets;
use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Interfaces\Confirmable;
use Bavix\Wallet\Traits\CanConfirm;
use Questocat\Referral\Traits\UserReferral;
use App\Models\Currency as Currency;


/**
 * @property mixed $id
 * @property mixed $uid
 * @property mixed $name
 * @property mixed $username
 * @property mixed $avatar
 * @property mixed $referred_by
 * @property mixed $affiliate_id
 * @property mixed $auth_token
 * @property mixed $roles
 * @method static findOrFail($id)
 * @method static where(string $string, string $string1)
 * @method static create(array $array)
 * @method static Search(mixed $input)
 * @mixin Builder
 */

class User extends Authenticatable implements Wallet, Confirmable, WalletFloat
{
    use HasFactory, Notifiable, HasWallets, UserReferral, CanConfirm, Notifiable, HasWalletFloat, GetBalance;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'avatar',
        'username',
        'password',
        'uid',
        'affiliate_id',
        'referred_by',
        'auth_token',
        'roles'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * @return bool
     * Check administrator permissions
     */
    public function isAdmin(): bool
    {
        if ($this->roles == 'admin') {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     * Check gateway permissions
     */
    public function isGate(): bool
    {
        if ($this->roles == 'admin' || $this->roles == 'gate') {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     * Check gateway permissions
     */
    public function isGateManager(): bool
    {
        if ($this->roles == 'admin' || $this->roles == 'gate_manager') {
            return true;
        }
        return false;
    }

    /**
     * Получить заявки.
     */
    public function orders(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\Order', 'user_uid', 'uid');
    }


    /**
     * Get gate orders.
     */
    public function gateOrders(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\Order', 'gate', 'uid');
    }


    /**
     * Если есть активная заявка
     * @return bool
     */
    public function hasActiveOrder(): bool
    {
        return $this->orders()->where('status', '!=', 'completed')->exists();
    }


    /**
     * Активная заявка токен сейла
     */
    public function activeTokenSaleOrder(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->orders()->where('status', '!=', 'completed')->where('destination', 'TokenSale');
    }

    /**
     * Получить настройки.
     */
    public function config(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\UserConfig', 'user_uid', 'uid');
    }


    /**
     * Переключить режим кошелька 'pro' или 'lite'
     * @param string $mode
     */
    public function switchMode(string $mode) {
        if ($this->isGate()) {
            UserConfig::updateOrCreate(
                ['user_uid' => $this->uid, 'meta' => 'mode'],
                ['value' => $mode]
            );
        }
        else {
            UserConfig::updateOrCreate(
                ['user_uid' => $this->uid, 'meta' => 'mode'],
                ['value' => 'lite']
            );
        }
    }

    public function paymentDetails(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\PaymentDetail', 'user_uid', 'uid');
    }

    public function referrals(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class,'referred_by', 'affiliate_id');
    }

    /**
     * Получить общий баланс DHB / USDT
     * @return float
     */
    public function getBalanceInner(): float
    {
        return $this->getWallet('DHB')->balanceFloat * Rate::getRates('DHB');
    }

    public function getBalanceFrozen()
    {
        $balance = 0;
        foreach ($this->wallets()->get() as $wallet) {
            if (stripos($wallet->name, '_gate')) {
                $balance += $wallet->balanceFloat * Rate::getRates(str_replace('_gate', '', $wallet->name));
            }
        }
        foreach ($this->orders()->where('gate', $this->uid)->where('status', '!=', 'completed')->where('destination', '!=', 'withdraw')->get() as $order) {
            $balance += $order->amount * Rate::getRates($order->currency);
        }
        return $balance;
    }

    public function getBalanceFree($currency): float
    {
        return ($this->getBalanceInner() - $this->getBalanceFrozen()) / Rate::getRates($currency);
    }


    /**
     * Получение списка шлюзов
     * @param $query
     * @return mixed
     */
    public function scopeGetGates($query)
    {
        return $query->where('roles', '=', 'admin')->orWhere('roles', '=', 'gate');
    }

    /**
     * Получить список всех балансов пользователя
     * @return string
     */
    public function getBalances(): string
    {
        $balances = array();
        foreach (Currency::all() as $currency) {
            $balances[] = array(
                'currency'=> $currency,
                'balance'   => $this->getWallet($currency->title)->balanceFloat,
                'payments'  => $currency->payments()->get()->toArray()
            );
        }
        return json_encode($balances, JSON_UNESCAPED_UNICODE);
    }

    public function scopeSearch($query, $q)
    {
        return $query->where('name','LIKE','%'.$q.'%')
            ->orWhere('username','LIKE','%'.$q.'%')
            ->orWhere('uid','LIKE','%'.$q.'%');
    }

    /**
     * Return filtered User model with
     * @param $filter
     * @return User
     */
    public function getUsersByFilter($filter)
    {
        return match ($filter) {
            'balance' => $this->withAggregate(['wallets' => function ($query) {
                $query->where('slug', 'DHB');
            }], 'balance')->orderBy('wallets_balance', 'DESC'),
            'referrals' => $this->withCount('referrals')->having('referrals_count', '>', 0)->orderBy('referrals_count', 'desc'),
            'orders' => $this->withCount(['gateOrders' => function($query) {
                $query->where('status', '=', 'completed');
            }])->having('gate_orders_count', '>', 0)->orderBy('gate_orders_count', 'desc')
        };
    }

}
