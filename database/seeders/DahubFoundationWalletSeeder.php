<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DahubFoundationWalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('wallets')->insert([
            [
                'holder_type' => 'App\Models\System',
                'holder_id' => '1',
                'name' => 'Dahub Foundation Wallet',
                'slug' => 'DHB_Fund_Wallet',
                'balance' => '0',
                'decimal_places' => '2'
            ],
        ]);

    }
}
