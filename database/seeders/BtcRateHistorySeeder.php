<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BtcRateHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->btcHistory();
    }

    private function btcHistory() {

        $coin_id = DB::table('coin_metadata')
                     ->select('id')
                     ->where('symbol', '=', "BTC")
                     ->first();

        DB::table('rates')->insert([
                                       'id' => (string) Str::uuid(),
                                       'coin_id' => $coin_id->id,
                                       'rate' => 0.0474,
                                       'special_rate' => 0.0593,
                                       'source' => config('sources.celsius_source_id'),
                                       'created_at' => '2021-01-17 12:00:00'
                                   ]);

        DB::table('rates')->insert([
                                       'id' => (string) Str::uuid(),
                                       'coin_id' => $coin_id->id,
                                       'rate' => 0.0451,
                                       'special_rate' => 0.0597,
                                       'source' => config('sources.celsius_source_id'),
                                       'created_at' => '2020-12-03 12:00:00'
                                   ]);

        DB::table('rates')->insert([
                                       'id' => (string) Str::uuid(),
                                       'coin_id' => $coin_id->id,
                                       'rate' => 0.0451,
                                       'special_rate' => 0.0620,
                                       'source' => config('sources.celsius_source_id'),
                                       'created_at' => '2020-07-26 12:00:00'
                                   ]);

        DB::table('rates')->insert([
                                       'id' => (string) Str::uuid(),
                                       'coin_id' => $coin_id->id,
                                       'rate' => 0.0403,
                                       'special_rate' => 0.0620,
                                       'source' => config('sources.celsius_source_id'),
                                       'created_at' => '2020-05-17 12:00:00'
                                   ]);

        DB::table('rates')->insert([
                                       'id' => (string) Str::uuid(),
                                       'coin_id' => $coin_id->id,
                                       'rate' => 0.0413,
                                       'special_rate' => 0.0727,
                                       'source' => config('sources.celsius_source_id'),
                                       'created_at' => '2020-04-14 12:00:00'
                                   ]);

        DB::table('rates')->insert([
                                       'id' => (string) Str::uuid(),
                                       'coin_id' => $coin_id->id,
                                       'rate' => 0.0392,
                                       'special_rate' => 0.0727,
                                       'source' => config('sources.celsius_source_id'),
                                       'created_at' => '2020-04-01 12:00:00'
                                   ]);

    }
}
