<?php

use App\Models\System;
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
        $orders = DB::table('orders')->where('destination', 'TokenSale')->get()->toArray();
        foreach ($orders as $order) {
            $user = App\Models\User::where('uid', $order->user_uid)->first();
            $user->getBalance('iUSDT');
            $user->getWallet('iUSDT')->depositFloat($order->dhb_amount * $order->dhb_rate , array('destination' => 'deposit to Inner Wallet', 'order_id' => $order->id));
            $user->getWallet('iUSDT')->refreshBalance();
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
