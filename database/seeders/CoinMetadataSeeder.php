<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoinMetadataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('coin_metadata')->insert([
            'id' => '32321a55-799c-440e-90b7-0d30dbfff8de',
            'name' => 'ethereum',
            'symbol' => 'ETH',
            'image' => 'https://s2.coinmarketcap.com/static/img/coins/128x128/1027.png'
        ]);

        DB::table('coin_metadata')->insert([
            'id' => 'ba1a3ab3-266c-46e2-afd8-e9080e4c6048',
            'name' => 'bitcoin',
            'symbol' => 'BTC',
            'image' => 'https://s2.coinmarketcap.com/static/img/coins/128x128/1.png'
        ]);

        DB::table('coin_metadata')->insert([
            'id' => 'dadc3116-d863-4f24-84db-ab198282ec1f',
            'name' => 'litecoin',
            'symbol' => 'LTC',
            'image' => 'https://s2.coinmarketcap.com/static/img/coins/128x128/2.png'
        ]);

        DB::table('coin_metadata')->insert([
            'id' => '5bfc635e-1919-430f-810f-4d28bf09e306',
            'name' => 'USD Coin',
            'symbol' => 'USDC',
            'image' => 'https://s2.coinmarketcap.com/static/img/coins/128x128/3408.png'
        ]);
    }
}
