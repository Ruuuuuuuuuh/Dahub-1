<?php

namespace App\Models;

use App\Helpers\Rate;
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
 * @method static findOrFail($id)
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

    /**
     * Получить баланс внутреннего токена
     * @return float
     */
    public function getBalanceInner(): float
    {
        if (!$this->hasWallet('iUSDT')) {
            $this->createWallet(
                [
                    'name' => 'Inner USD Token',
                    'slug' => 'iUSDT',
                    'decimal_places' => 2
                ]
            );
        }
        return $this->getWallet('iUSDT')->balanceFloat;
    }

    public function getBalanceFrozen(): float
    {
        if (!$this->hasWallet('iUSDT_frozen')) {
            $this->createWallet(
                [
                    'name' => 'iUSDT frozen',
                    'slug' => 'iUSDT_frozen',
                    'decimal_places' => 2
                ]
            );
        }
        return $this->getWallet('iUSDT_frozen')->balanceFloat;
    }

    public function getBalanceFree($currency): float
    {
        return ($this->getBalanceInner() - $this->getBalanceFrozen()) / Rate::getRates($currency);
    }

    public function freezeTokens($currency, $amount)
    {
        $amount = Rate::getRates($currency) * $amount;
        $this->getWallet('iUSDT_frozen')->depositFloat($amount, array('destination' => 'Заморозка токенов'));
        $this->getWallet('iUSDT_frozen')->refreshBalance();
    }

    public function unfreezeTokens($currency, $amount)
    {
        $amount = Rate::getRates($currency) * $amount;
        $this->getWallet('iUSDT_frozen')->withdrawFloat($amount, array('destination' => 'Разморозка токенов'));
        $this->getWallet('iUSDT_frozen')->refreshBalance();
    }

    public function depositInner($currency, $amount) {
        $amount = Rate::getRates($currency) * $amount;
        $this->getWallet('iUSDT')->depositFloat($amount, array('destination' => 'Пополнение внутренних токенов'));
        $this->getWallet('iUSDT')->refreshBalance();
    }

    public function withdrawInner($currency, $amount)
    {
        $amount = Rate::getRates($currency) * $amount;
        $this->getWallet('iUSDT')->withdrawFloat($amount, array('destination' => 'Сжигание внутренних токенов'));
        $this->getWallet('iUSDT')->refreshBalance();
    }
}
