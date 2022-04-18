<?php

use App\Models\System;
use Bavix\Wallet\Models\Transaction;
use Bavix\Wallet\Models\Wallet;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ExchangeReferralBonusesToDhb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            //
        });
        $system = System::first();
        foreach (\Bavix\Wallet\Models\Transaction::where('meta', 'like', '%"destination": "referral"%')->where('payable_type', 'App\Models\User')->get() as $transaction) {
            $user = \App\Models\User::where('id', $transaction->payable_id)->first();
            $currency = Wallet::where('id', $transaction->wallet_id)->first()->slug;
            $wallet = $user->getWallet($currency);
            if ($wallet->balance >= abs($transaction->amount)) {
                $wallet->withdraw(abs($transaction->amount),  array('destination' => 'convert referral to DHB'));
                $transaction->meta = '{"destination": "convert referral to DHB"}';
                $transaction->save();
                $wallet->refreshBalance();
                $system->getWallet('DHBFundWallet')->transferFloat($user->getWallet('DHB'), abs($transaction->amountFloat) * \App\Helpers\Rate::getRatesDHB($currency),  array('destination' => 'referral'));
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            //
        });
    }
}
