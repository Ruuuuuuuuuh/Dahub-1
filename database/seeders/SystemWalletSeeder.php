<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SystemWalletSeeder extends Seeder
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
                'name' => 'DHB',
                'slug' => 'DHB',
                'balance' => '0',
                'decimal_places' => '2'
            ],
            [
                'holder_type' => 'App\Models\System',
                'holder_id' => '1',
                'name' => 'USDT',
                'slug' => 'USDT',
                'balance' => '0',
                'decimal_places' => '2'
            ],
            [
                'holder_type' => 'App\Models\System',
                'holder_id' => '1',
                'name' => 'BTC',
                'slug' => 'BTC',
                'balance' => '0',
                'decimal_places' => '2'
            ],
            [
                'holder_type' => 'App\Models\System',
                'holder_id' => '1',
                'name' => 'ETH',
                'slug' => 'ETH',
                'balance' => '0',
                'decimal_places' => '2'
            ]
        ]);

        \DB::table('systems')->insert([
            'id' => 1
        ]);
    }
}
