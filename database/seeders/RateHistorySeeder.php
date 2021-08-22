<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RateHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->ethHistory();
        $this->ltcHistory();


    }

    private function ltcHistory()
    {
        $coin_id = DB::table('coin_metadata')
                     ->select('id')
                     ->where('symbol', '=', "LTC")
                     ->first();

        DB::table('rates')->insert([
                                       'id' => (string) Str::uuid(),
                                       'coin_id' => $coin_id->id,
                                       'rate' => 0.0408,
                                       'special_rate' => 0.0512,
                                       'source' => config('sources.celsius_source_id'),
                                       'created_at' => '2021-03-02 12:00:00'
                                   ]);

        DB::table('rates')->insert([
                                       'id' => (string) Str::uuid(),
                                       'coin_id' => $coin_id->id,
                                       'rate' => 0.0408,
                                       'special_rate' => 0.0533,
                                       'source' => config('sources.celsius_source_id'),
                                       'created_at' => '2021-02-13 12:00:00'
                                   ]);

        DB::table('rates')->insert([
                                       'id' => (string) Str::uuid(),
                                       'coin_id' => $coin_id->id,
                                       'rate' => 0.0505,
                                       'special_rate' => 0.0661,
                                       'source' => config('sources.celsius_source_id'),
                                       'created_at' => '2020-10-20 12:00:00'
                                   ]);

        DB::table('rates')->insert([
                                       'id' => (string) Str::uuid(),
                                       'coin_id' => $coin_id->id,
                                       'rate' => 0.0505,
                                       'special_rate' => 0.0688,
                                       'source' => config('sources.celsius_source_id'),
                                       'created_at' => '2020-08-01 12:00:00'
                                   ]);

        DB::table('rates')->insert([
                                       'id' => (string) Str::uuid(),
                                       'coin_id' => $coin_id->id,
                                       'rate' => 0.0451,
                                       'special_rate' => 0.0613,
                                       'source' => config('sources.celsius_source_id'),
                                       'created_at' => '2020-07-26 12:00:00'
                                   ]);

        DB::table('rates')->insert([
                                       'id' => (string) Str::uuid(),
                                       'coin_id' => $coin_id->id,
                                       'rate' => 0.0413,
                                       'special_rate' => 0.0562,
                                       'source' => config('sources.celsius_source_id'),
                                       'created_at' => '2020-04-28 12:00:00'
                                   ]);

        DB::table('rates')->insert([
                                       'id' => (string) Str::uuid(),
                                       'coin_id' => $coin_id->id,
                                       'rate' => 0.0372,
                                       'special_rate' => 0.0505,
                                       'source' => config('sources.celsius_source_id'),
                                       'created_at' => '2020-04-08 12:00:00'
                                   ]);

        DB::table('rates')->insert([
                                       'id' => (string) Str::uuid(),
                                       'coin_id' => $coin_id->id,
                                       'rate' => 0.0325,
                                       'special_rate' => 0.0441,
                                       'source' => config('sources.celsius_source_id'),
                                       'created_at' => '2020-04-08 12:00:00'
                                   ]);
    }

    private function ethHistory() {
        $coin_id = DB::table('coin_metadata')
                     ->select('id')
                     ->where('symbol', '=', "ETH")
                     ->first();

        DB::table('rates')->insert([
                                       'id' => (string) Str::uuid(),
                                       'coin_id' => $coin_id->id,
                                       'rate' => 0.0505,
                                       'special_rate' => 0.0688,
                                       'source' => config('sources.celsius_source_id'),
                                       'created_at' => '2020-09-11 12:00:00'
                                   ]);

        DB::table('rates')->insert([
                                       'id' => (string) Str::uuid(),
                                       'coin_id' => $coin_id->id,
                                       'rate' => 0.0455,
                                       'special_rate' => 0.0620,
                                       'source' => config('sources.celsius_source_id'),
                                       'created_at' => '2020-07-31 12:00:00'
                                   ]);

        DB::table('rates')->insert([
                                       'id' => (string) Str::uuid(),
                                       'coin_id' => $coin_id->id,
                                       'rate' => 0.0382,
                                       'special_rate' => 0.0727,
                                       'source' => config('sources.celsius_source_id'),
                                       'created_at' => '2020-05-29 12:00:00'
                                   ]);

        DB::table('rates')->insert([
                                       'id' => (string) Str::uuid(),
                                       'coin_id' => $coin_id->id,
                                       'rate' => 0.0382,
                                       'special_rate' => 0.0727,
                                       'source' => config('sources.celsius_source_id'),
                                       'created_at' => '2020-04-28 12:00:00'
                                   ]);

        DB::table('rates')->insert([
                                       'id' => (string) Str::uuid(),
                                       'coin_id' => $coin_id->id,
                                       'rate' => 0.0382,
                                       'special_rate' => 0.0519,
                                       'source' => config('sources.celsius_source_id'),
                                       'created_at' => '2020-04-14 12:00:00'
                                   ]);

        DB::table('rates')->insert([
                                       'id' => (string) Str::uuid(),
                                       'coin_id' => $coin_id->id,
                                       'rate' => 0.0233,
                                       'special_rate' => 0.0315,
                                       'source' => config('sources.celsius_source_id'),
                                       'created_at' => '2020-04-01 12:00:00'
                                   ]);
    }
}
