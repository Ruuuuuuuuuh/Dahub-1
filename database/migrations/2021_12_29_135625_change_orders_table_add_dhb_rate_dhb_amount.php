<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeOrdersTableAddDhbRateDhbAmount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {

        });

        DB::table('orders')
            ->where('destination', 'TokenSale')
            ->where('id', '<=', 150)
            ->update([
                'dhb_rate' => '0.05',
                'dhb_amount' => DB::raw("`amount`"),
                'amount' => DB::raw("`amount` * 0.05"),
            ]);

        DB::table('orders')
            ->where('destination', 'TokenSale')
            ->where('id', '>', 150)
            ->update([
                'dhb_rate' => '0.06',
                'dhb_amount' => DB::raw("`amount`"),
                'amount' => DB::raw("`amount` * 0.06"),
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
        });

        DB::table('orders')
            ->where('destination', 'TokenSale')
            ->where('id', '<=', 150)
            ->update([
                'dhb_rate' => '',
                'dhb_amount' => '',
                'amount' => DB::raw("`amount` / 0.05"),
            ]);

        DB::table('orders')
            ->where('destination', 'TokenSale')
            ->where('id', '>', 150)
            ->update([
                'dhb_rate' => '',
                'dhb_amount' => '',
                'amount' => DB::raw("`amount` / 0.06"),
            ]);
    }


}
