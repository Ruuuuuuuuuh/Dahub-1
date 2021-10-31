<?php

namespace App\Models;

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
use Questocat\Referral\Traits\UserReferral;

/**
 * @property mixed $roles
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
     * Получить заявки.
     */
    public function orders(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\Order', 'user_uid', 'uid');
    }


    /**
     * Получить настройки.
     */
    public function config(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\UserConfig', 'user_uid', 'uid');
    }

    public function paymentDetails(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\PaymentDetail', 'user_uid', 'uid');
    }

    public function getBalance($currency, $decimal = 2): float
    {
        if (!$this->hasWallet($currency)) {
            $this->createWallet(
                [
                    'name' => $currency,
                    'slug' => $currency,
                    'decimal_places' => System::findOrFail(1)->getWallet($currency)->decimal_places
                ]
            );
        }
        return $this->getWallet($currency)->balanceFloat;
    }

    public function getBalanceFrozen($currency, $decimal = 2): float
    {
        if (!$this->hasWallet($currency.'_frozen')) {
            $this->createWallet(
                [
                    'name' => $currency.'_frozen',
                    'slug' => $currency.'_frozen',
                    'decimal_places' => $this->getWallet($currency)->decimal_places
                ]
            );
        }
        return $this->getWallet($currency.'_frozen')->balanceFloat;
    }

    public function getBalanceFree($currency): float
    {
        return $this->getBalance($currency) - $this->getBalanceFrozen($currency);
    }

    public function freezeTokens($currency, $amount)
    {
        $this->getWallet($currency.'_frozen')->depositFloat($amount, array('destination' => 'Заморозка токенов'));
        $this->getWallet($currency.'_frozen')->refreshBalance();
    }

    public function unfreezeTokens($currency, $amount)
    {
        $this->getWallet($currency.'_frozen')->withdrawFloat($amount, array('destination' => 'Разморозка токенов'));
        $this->getWallet($currency.'_frozen')->refreshBalance();
    }

}
