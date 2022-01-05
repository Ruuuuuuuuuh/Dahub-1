<?php

use App\Models\System;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DepositIusdtAndAddRatesToRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rates', function (Blueprint $table) {
            //
        });
        DB::table('rates')->insert([
            ['title' => 'DHB', 'value' => 0.05],
            ['title' => 'DHB', 'value' => 0.06]
        ]);
        $system = System::findOrFail(1);
        $system->createWallet(
            [
                'name' => 'Inner USD Token',
                'slug' => 'iUSDT',
                'decimal_places' => 2
            ]
        );
        $system->createWallet(
            [
                'name' => 'Inner USD Token',
                'slug' => 'iUSDT_frozen',
                'decimal_places' => 2
            ]
        );
        foreach (User::all() as $user) {
            $dhb = 0;
            foreach ($user->orders()->where('status', 'completed')->get() as $order) {
                $dhb += $order->dhb_amount;
                $user->getBalance('iUSDT');
                $user->getWallet('iUSDT')->depositFloat($order->dhb_amount * $order->dhb_rate , array('destination' => 'deposit to Inner Wallet', 'order_id' => $order->id));
                $user->getWallet('iUSDT')->refreshBalance();
            }
            $user->getBalance('iUSDT');
            if ($user->getWallet('DHB')->balanceFloat > $dhb) $user->getWallet('iUSDT')->depositFloat(($user->getWallet('DHB')->balanceFloat - $dhb)  * 0.05, array('destination' => 'deposit to Inner Wallet'));
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rates', function (Blueprint $table) {
            //
        });
        DB::table('rates')->truncate();
        DB::table('transactions')
            ->where('meta', 'like', '%deposit to Inner Wallet%')
            ->delete();
        DB::table('wallets')
            ->where('slug', 'iUSDT')
            ->orWhere('slug', 'iUSDT_frozen')
            ->delete();
    }
}
