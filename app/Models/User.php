<?php

namespace App\Models;

use App\Helpers\Rate;
use App\Models\System as System;
use Bavix\Wallet\Interfaces\WalletFloat;
use Bavix\Wallet\Models\Transaction;
use Bavix\Wallet\Traits\HasWalletFloat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Bavix\Wallet\Traits\HasWallets;
use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Interfaces\Confirmable;
use Bavix\Wallet\Traits\CanConfirm;
use Illuminate\Support\Carbon;
use Questocat\Referral\Traits\UserReferral;
use App\Models\Currency as Currency;


/**
 * @property mixed $roles
 * @property mixed $uid
 * @method static findOrFail($id)
 * @method static where(string $string, string $string1)
 */

class User extends Authenticatable implements Wallet, Confirmable, WalletFloat
{
    use HasFactory, Notifiable, HasWallets, UserReferral, CanConfirm, Notifiable, HasWalletFloat;

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
     * Если есть активная заявка
     * @return bool
     */
    public function hasActiveOrder(): bool
    {
        return $this->orders()->where('status', '!=', 'completed')->where('destination', 'TokenSale')->exists();
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


    public function getBalance($currency): float
    {
        if (!$this->hasWallet($currency)) {
            $this->createWallet(
                [
                    'name' => $currency,
                    'slug' => $currency,
                    'decimal_places' => Currency::where('title', str_replace('_gate', '', $currency))->first()->decimal_places
                ]
            );
        }
        $this->getWallet($currency)->refreshBalance();
        return $this->getWallet($currency)->balanceFloat;
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
     * Считает количество долларов на балансе исходя из графика изменения стоимости токена
     * @return float|int
     */
    public function getAvailableBalance() {
        $balance = 0;
        $rates = \App\Models\Rate::all()->toArray();
        foreach (\App\Models\Transaction::where('payable_id', $this->id)->where('wallet_id', $this->getWallet('DHB')->id)->get() as $transaction) {
            $curRate = 0;
            foreach ($rates as $i => $rate) {
                if ($transaction->created_at->gte($rate['created_at'])) {
                    $curRate = $rates[$i]['value'];
                }
                else {
                    $curRate = $rates[$i-1]['value'];
                    break;
                }
            }
            $balance += ($transaction->amount / 100) * $curRate;
        }
        return $balance;
    }

    public function freezeTokens($currency, $amount)
    {
        $amount = Rate::getRates($currency) * $amount;
        $this->getBalanceFrozen();
        $this->getWallet('iUSDT_frozen')->depositFloat($amount, array('destination' => 'Заморозка токенов'));
        $this->getWallet('iUSDT_frozen')->refreshBalance();
    }

    public function unfreezeTokens($currency, $amount)
    {
        $amount = Rate::getRates($currency) * $amount;
        $this->getBalanceFrozen();
        $this->getWallet('iUSDT_frozen')->withdrawFloat($amount, array('destination' => 'Разморозка токенов'));
        $this->getWallet('iUSDT_frozen')->refreshBalance();
    }

    public function depositInner($currency, $amount) {
        $amount = Rate::getRates($currency) * $amount;
        $this->getBalanceInner();
        $this->getWallet('iUSDT')->depositFloat($amount, array('destination' => 'deposit to Inner Wallet'));
        $this->getWallet('iUSDT')->refreshBalance();
    }

    public function withdrawInner($currency, $amount)
    {
        $amount = Rate::getRates($currency) * $amount;
        $this->getBalanceInner();
        $this->getWallet('iUSDT')->withdrawFloat($amount, array('destination' => 'Сжигание внутренних токенов'));
        $this->getWallet('iUSDT')->refreshBalance();
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

}
