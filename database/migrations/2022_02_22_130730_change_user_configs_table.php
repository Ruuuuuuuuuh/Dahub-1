<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeUserConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_configs', function (Blueprint $table) {
            $table->bigInteger('user_uid')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_configs', function (Blueprint $table) {
            Schema::table('user_configs', function (Blueprint $table) {
                $table->Integer('user_uid')->change();
            });
        });
    }
}
