<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GeminiHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //Reset Dates on all Gemini Coins

        DB::table('rates')
          ->where('source', '=', "gemini")
          ->update(['created_at' => Carbon::create(2022, 3, 16, 0, 0, 0, 'America/New_York')]);

        // APE

        //Fetch coin
        $coin = DB::table('coin_metadata')
                   ->where('symbol', '=', 'APE')
                   ->first();

        // Update old rate
        DB::table('rates')
          ->where('coin_id', '=', $coin->id)
          ->update(['rate' => 0.0558]);

        //insert new rate
        DB::table('rates')->insert([
           'id' => (string) Str::uuid(),
           'coin_id' => $coin->id,
           'rate' => 0.0688,
           'source' => 'gemini',
           'created_at' => Carbon::create(2022, 5, 1, 0, 0, 0, 'America/New_York')
       ]);

        //insert new rate
        DB::table('rates')->insert([
           'id' => (string) Str::uuid(),
           'coin_id' => $coin->id,
           'rate' => 0.0610,
           'source' => 'gemini',
           'created_at' => Carbon::create(2022, 7, 18, 0, 0, 0, 'America/New_York')
       ]);

        // BTC

        //Fetch coin
        $coin = DB::table('coin_metadata')
                  ->where('symbol', '=', 'BTC')
                  ->first();

        // Update old rate
        DB::table('rates')
          ->where('coin_id', '=', $coin->id)
          ->update(['rate' => 0.0149, 'created_at' => Carbon::create(2022, 1, 1, 0, 0, 0, 'America/New_York')]);

        //insert new rate
        DB::table('rates')->insert([
           'id' => (string) Str::uuid(),
           'coin_id' => $coin->id,
           'rate' => 0.0101,
           'source' => 'gemini',
           'created_at' => Carbon::create(2022, 2, 1, 0, 0, 0, 'America/New_York')
       ]);

        //insert new rate
        DB::table('rates')->insert([
           'id' => (string) Str::uuid(),
           'coin_id' => $coin->id,
           'rate' => 0.0275,
           'source' => 'gemini',
           'created_at' => Carbon::create(2022, 7, 18, 0, 0, 0, 'America/New_York')
       ]);

        // CHZ

        //Fetch coin
        $coin = DB::table('coin_metadata')
                  ->where('symbol', '=', 'CHZ')
                  ->first();

        // Update old rate
        DB::table('rates')
          ->where('coin_id', '=', $coin->id)
          ->update(['rate' => 0.0149, 'created_at' => Carbon::create(2022, 7, 18, 0, 0, 0, 'America/New_York')]);

        // ETH

        //Fetch coin
        $coin = DB::table('coin_metadata')
                  ->where('symbol', '=', 'ETH')
                  ->first();

        // Update old rate
        DB::table('rates')
          ->where('coin_id', '=', $coin->id)
          ->update(['rate' => 0.0200, 'created_at' => Carbon::create(2022, 1, 1, 0, 0, 0, 'America/New_York')]);

        //insert new rate
        DB::table('rates')->insert([
           'id' => (string) Str::uuid(),
           'coin_id' => $coin->id,
           'rate' => 0.0126,
           'source' => 'gemini',
           'created_at' => Carbon::create(2022, 2, 1, 0, 0, 0, 'America/New_York')
       ]);

        //insert new rate
        DB::table('rates')->insert([
           'id' => (string) Str::uuid(),
           'coin_id' => $coin->id,
           'rate' => 0.0304,
           'source' => 'gemini',
           'created_at' => Carbon::create(2022, 7, 18, 0, 0, 0, 'America/New_York')
       ]);

        // FET

        //Fetch coin
        $coin = DB::table('coin_metadata')
                  ->where('symbol', '=', 'FET')
                  ->first();

        // Update old rate
        DB::table('rates')
          ->where('coin_id', '=', $coin->id)
          ->update(['rate' => 0.0250, 'created_at' => Carbon::create(2022, 7, 18, 0, 0, 0, 'America/New_York')]);

        // GUSD

        //Fetch coin
        $coin = DB::table('coin_metadata')
                  ->where('symbol', '=', 'GUSD')
                  ->first();

        // Update old rate
        DB::table('rates')
          ->where('coin_id', '=', $coin->id)
          ->update(['rate' => 0.0805]);

        //insert new rate
        DB::table('rates')->insert([
           'id' => (string) Str::uuid(),
           'coin_id' => $coin->id,
           'rate' => 0.0690,
           'source' => 'gemini',
           'created_at' => Carbon::create(2022, 4, 1, 0, 0, 0, 'America/New_York')
       ]);

        //insert new rate
        DB::table('rates')->insert([
           'id' => (string) Str::uuid(),
           'coin_id' => $coin->id,
           'rate' => 0.0715,
           'source' => 'gemini',
           'created_at' => Carbon::create(2022, 7, 18, 0, 0, 0, 'America/New_York')
       ]);

        // LRC

        //Fetch coin
        $coin = DB::table('coin_metadata')
                  ->where('symbol', '=', 'LRC')
                  ->first();

        // Update old rate
        DB::table('rates')
          ->where('coin_id', '=', $coin->id)
          ->update(['rate' => 0.0403, 'created_at' => Carbon::create(2022, 7, 18, 0, 0, 0, 'America/New_York')]);

        // SKL

        //Fetch coin
        $coin = DB::table('coin_metadata')
                  ->where('symbol', '=', 'SKL')
                  ->first();

        // Update old rate
        DB::table('rates')
          ->where('coin_id', '=', $coin->id)
          ->update(['rate' => 0.0149, 'created_at' => Carbon::create(2022, 7, 18, 0, 0, 0, 'America/New_York')]);

        // SOL

        //Fetch coin
        $coin = DB::table('coin_metadata')
                  ->where('symbol', '=', 'SOL')
                  ->first();

        // Update old rate
        DB::table('rates')
          ->where('coin_id', '=', $coin->id)
          ->update(['rate' => 0.0429]);

        //insert new rate
        DB::table('rates')->insert([
           'id' => (string) Str::uuid(),
           'coin_id' => $coin->id,
           'rate' => 0.0455,
           'source' => 'gemini',
           'created_at' => Carbon::create(2022, 4, 1, 0, 0, 0, 'America/New_York')
       ]);

        //insert new rate
        DB::table('rates')->insert([
           'id' => (string) Str::uuid(),
           'coin_id' => $coin->id,
           'rate' => 0.0506,
           'source' => 'gemini',
           'created_at' => Carbon::create(2022, 7, 18, 0, 0, 0, 'America/New_York')
       ]);

        // USDC

        //Fetch coin
        $coin = DB::table('coin_metadata')
                  ->where('symbol', '=', 'USDC')
                  ->first();

        // Update old rate
        DB::table('rates')
          ->where('coin_id', '=', $coin->id)
          ->update(['rate' => 0.0799]);

        //insert new rate
        DB::table('rates')->insert([
           'id' => (string) Str::uuid(),
           'coin_id' => $coin->id,
           'rate' => 0.0636,
           'source' => 'gemini',
           'created_at' => Carbon::create(2022, 4, 1, 0, 0, 0, 'America/New_York')
       ]);

        //insert new rate
        DB::table('rates')->insert([
           'id' => (string) Str::uuid(),
           'coin_id' => $coin->id,
           'rate' => 0.0531,
           'source' => 'gemini',
           'created_at' => Carbon::create(2022, 6, 1, 0, 0, 0, 'America/New_York')
       ]);

        //insert new rate
        DB::table('rates')->insert([
           'id' => (string) Str::uuid(),
           'coin_id' => $coin->id,
           'rate' => 0.0636,
           'source' => 'gemini',
           'created_at' => Carbon::create(2022, 7, 18, 0, 0, 0, 'America/New_York')
       ]);

        // FTM

        //Fetch coin
        $coin = DB::table('coin_metadata')
                  ->where('symbol', '=', 'FTM')
                  ->first();

        // Update old rate
        DB::table('rates')
          ->where('coin_id', '=', $coin->id)
          ->update(['rate' => 0.0266]);

        //insert new rate
        DB::table('rates')->insert([
           'id' => (string) Str::uuid(),
           'coin_id' => $coin->id,
           'rate' => 0.0127,
           'source' => 'gemini',
           'created_at' => Carbon::create(2022, 5, 1, 0, 0, 0, 'America/New_York')
       ]);

        // GRT

        //Fetch coin
        $coin = DB::table('coin_metadata')
                  ->where('symbol', '=', 'GRT')
                  ->first();

        // Update old rate
        DB::table('rates')
          ->where('coin_id', '=', $coin->id)
          ->update(['rate' => 0.0643, 'created_at' => Carbon::create(2022, 1, 1, 0, 0, 0, 'America/New_York')]);

        //insert new rate
        DB::table('rates')->insert([
           'id' => (string) Str::uuid(),
           'coin_id' => $coin->id,
           'rate' => 0.0305,
           'source' => 'gemini',
           'created_at' => Carbon::create(2022, 2, 1, 0, 0, 0, 'America/New_York')
       ]);

        //insert new rate
        DB::table('rates')->insert([
           'id' => (string) Str::uuid(),
           'coin_id' => $coin->id,
           'rate' => 0.0250,
           'source' => 'gemini',
           'created_at' => Carbon::create(2022, 5, 1, 0, 0, 0, 'America/New_York')
       ]);

        // MATIC

        //Fetch coin
        $coin = DB::table('coin_metadata')
                  ->where('symbol', '=', 'MATIC')
                  ->first();

        // Update old rate
        DB::table('rates')
          ->where('coin_id', '=', $coin->id)
          ->update(['rate' => 0.0202]);

        //insert new rate
        DB::table('rates')->insert([
           'id' => (string) Str::uuid(),
           'coin_id' => $coin->id,
           'rate' => 0.0543,
           'source' => 'gemini',
           'created_at' => Carbon::create(2022, 5, 1, 0, 0, 0, 'America/New_York')
       ]);

        // SUSHI

        //Fetch coin
        $coin = DB::table('coin_metadata')
                  ->where('symbol', '=', 'SUSHI')
                  ->first();

        // Update old rate
        DB::table('rates')
          ->where('coin_id', '=', $coin->id)
          ->update(['rate' => 0.0101]);

        //insert new rate
        DB::table('rates')->insert([
           'id' => (string) Str::uuid(),
           'coin_id' => $coin->id,
           'rate' => 0.0200,
           'source' => 'gemini',
           'created_at' => Carbon::create(2022, 5, 1, 0, 0, 0, 'America/New_York')
       ]);

        //insert new rate
        DB::table('rates')->insert([
           'id' => (string) Str::uuid(),
           'coin_id' => $coin->id,
           'rate' => 0.0250,
           'source' => 'gemini',
           'created_at' => Carbon::create(2022, 6, 1, 0, 0, 0, 'America/New_York')
       ]);

        // 1INCH

        //Fetch coin
        $coin = DB::table('coin_metadata')
                  ->where('symbol', '=', '1INCH')
                  ->first();

        // Update old rate
        DB::table('rates')
          ->where('coin_id', '=', $coin->id)
          ->update(['rate' => 0.0351]);

        //insert new rate
        DB::table('rates')->insert([
           'id' => (string) Str::uuid(),
           'coin_id' => $coin->id,
           'rate' => 0.0805,
           'source' => 'gemini',
           'created_at' => Carbon::create(2022, 4, 1, 0, 0, 0, 'America/New_York')
       ]);

        // BCH

        //Fetch coin
        $coin = DB::table('coin_metadata')
                  ->where('symbol', '=', 'BCH')
                  ->first();

        // Update old rate
        DB::table('rates')
          ->where('coin_id', '=', $coin->id)
          ->update(['rate' => 0.0512]);

        //insert new rate
        DB::table('rates')->insert([
           'id' => (string) Str::uuid(),
           'coin_id' => $coin->id,
           'rate' => 0.0533,
           'source' => 'gemini',
           'created_at' => Carbon::create(2022, 4, 1, 0, 0, 0, 'America/New_York')
       ]);

        // CRV

        //Fetch coin
        $coin = DB::table('coin_metadata')
                  ->where('symbol', '=', 'CRV')
                  ->first();

        // Update old rate
        DB::table('rates')
          ->where('coin_id', '=', $coin->id)
          ->update(['rate' => 0.0616]);

        //insert new rate
        DB::table('rates')->insert([
           'id' => (string) Str::uuid(),
           'coin_id' => $coin->id,
           'rate' => 0.0805,
           'source' => 'gemini',
           'created_at' => Carbon::create(2022, 4, 1, 0, 0, 0, 'America/New_York')
       ]);

        // AMP

        //Fetch coin
        $coin = DB::table('coin_metadata')
                  ->where('symbol', '=', 'AMP')
                  ->first();

        // Update old rate
        DB::table('rates')
          ->where('coin_id', '=', $coin->id)
          ->update(['rate' => 0.0050]);

        //insert new rate
        DB::table('rates')->insert([
           'id' => (string) Str::uuid(),
           'coin_id' => $coin->id,
           'rate' => 0.0045,
           'source' => 'gemini',
           'created_at' => Carbon::create(2022, 6, 1, 0, 0, 0, 'America/New_York')
       ]);

        // ANKR

        //Fetch coin
        $coin = DB::table('coin_metadata')
                  ->where('symbol', '=', 'AMP')
                  ->first();

        // Update old rate
        DB::table('rates')
          ->where('coin_id', '=', $coin->id)
          ->update(['rate' => 0.0101]);

        //insert new rate
        DB::table('rates')->insert([
           'id' => (string) Str::uuid(),
           'coin_id' => $coin->id,
           'rate' => 0.0124,
           'source' => 'gemini',
           'created_at' => Carbon::create(2022, 6, 1, 0, 0, 0, 'America/New_York')
       ]);

        // BAL

        //Fetch coin
        $coin = DB::table('coin_metadata')
                  ->where('symbol', '=', 'BAL')
                  ->first();

        // Update old rate
        DB::table('rates')
          ->where('coin_id', '=', $coin->id)
          ->update(['rate' => 0.0125]);

        //insert new rate
        DB::table('rates')->insert([
           'id' => (string) Str::uuid(),
           'coin_id' => $coin->id,
           'rate' => 0.0612,
           'source' => 'gemini',
           'created_at' => Carbon::create(2022, 6, 1, 0, 0, 0, 'America/New_York')
       ]);

        // BNT

        //Fetch coin
        $coin = DB::table('coin_metadata')
                  ->where('symbol', '=', 'BNT')
                  ->first();

        // Update old rate
        DB::table('rates')
          ->where('coin_id', '=', $coin->id)
          ->update(['rate' => 0.0715, 'created_at' => Carbon::create(2022, 6, 1, 0, 0, 0, 'America/New_York')]);

        // DAI

        //Fetch coin
        $coin = DB::table('coin_metadata')
                  ->where('symbol', '=', 'DAI')
                  ->first();

        // Update old rate
        DB::table('rates')
          ->where('coin_id', '=', $coin->id)
          ->update(['rate' => 0.0643]);

        //insert new rate
        DB::table('rates')->insert([
           'id' => (string) Str::uuid(),
           'coin_id' => $coin->id,
           'rate' => 0.0531,
           'source' => 'gemini',
           'created_at' => Carbon::create(2022, 6, 1, 0, 0, 0, 'America/New_York')
       ]);

        // INJ

        //Fetch coin
        $coin = DB::table('coin_metadata')
                  ->where('symbol', '=', 'INJ')
                  ->first();

        // Update old rate
        DB::table('rates')
          ->where('coin_id', '=', $coin->id)
          ->update(['rate' => 0.0151]);

        //insert new rate
        DB::table('rates')->insert([
           'id' => (string) Str::uuid(),
           'coin_id' => $coin->id,
           'rate' => 0.0125,
           'source' => 'gemini',
           'created_at' => Carbon::create(2022, 6, 1, 0, 0, 0, 'America/New_York')
       ]);

        // LINK

        //Fetch coin
        $coin = DB::table('coin_metadata')
                  ->where('symbol', '=', 'LINK')
                  ->first();

        // Update old rate
        DB::table('rates')
          ->where('coin_id', '=', $coin->id)
          ->update(['rate' => 0.0135, 'created_at' => Carbon::create(2022, 1, 1, 0, 0, 0, 'America/New_York')]);

        //insert new rate
        DB::table('rates')->insert([
           'id' => (string) Str::uuid(),
           'coin_id' => $coin->id,
           'rate' => 0.0050,
           'source' => 'gemini',
           'created_at' => Carbon::create(2022, 2, 1, 0, 0, 0, 'America/New_York')
       ]);

        //insert new rate
        DB::table('rates')->insert([
           'id' => (string) Str::uuid(),
           'coin_id' => $coin->id,
           'rate' => 0.0045,
           'source' => 'gemini',
           'created_at' => Carbon::create(2022, 6, 1, 0, 0, 0, 'America/New_York')
       ]);

        // LPT

        //Fetch coin
        $coin = DB::table('coin_metadata')
                  ->where('symbol', '=', 'LPT')
                  ->first();

        // Update old rate
        DB::table('rates')
          ->where('coin_id', '=', $coin->id)
          ->update(['rate' => 0.0050]);

        //insert new rate
        DB::table('rates')->insert([
           'id' => (string) Str::uuid(),
           'coin_id' => $coin->id,
           'rate' => 0.0074,
           'source' => 'gemini',
           'created_at' => Carbon::create(2022, 6, 1, 0, 0, 0, 'America/New_York')
       ]);

        // OXT

        //Fetch coin
        $coin = DB::table('coin_metadata')
                  ->where('symbol', '=', 'OXT')
                  ->first();

        // Update old rate
        DB::table('rates')
          ->where('coin_id', '=', $coin->id)
          ->update(['rate' => 0.0050]);

        //insert new rate
        DB::table('rates')->insert([
           'id' => (string) Str::uuid(),
           'coin_id' => $coin->id,
           'rate' => 0.0045,
           'source' => 'gemini',
           'created_at' => Carbon::create(2022, 6, 1, 0, 0, 0, 'America/New_York')
       ]);

        // PAXG

        //Fetch coin
        $coin = DB::table('coin_metadata')
                  ->where('symbol', '=', 'PAXG')
                  ->first();

        // Update old rate
        DB::table('rates')
          ->where('coin_id', '=', $coin->id)
          ->update(['rate' => 0.0050]);

        //insert new rate
        DB::table('rates')->insert([
           'id' => (string) Str::uuid(),
           'coin_id' => $coin->id,
           'rate' => 0.0045,
           'source' => 'gemini',
           'created_at' => Carbon::create(2022, 6, 1, 0, 0, 0, 'America/New_York')
       ]);

        // RBN

        //Fetch coin
        $coin = DB::table('coin_metadata')
                  ->where('symbol', '=', 'RBN')
                  ->first();

        // Update old rate
        DB::table('rates')
          ->where('coin_id', '=', $coin->id)
          ->update(['rate' => 0.0194, 'created_at' => Carbon::create(2022, 6, 1, 0, 0, 0, 'America/New_York')]);

        // REN

        //Fetch coin
        $coin = DB::table('coin_metadata')
                  ->where('symbol', '=', 'REN')
                  ->first();

        // Update old rate
        DB::table('rates')
          ->where('coin_id', '=', $coin->id)
          ->update(['rate' => 0.0050]);

        //insert new rate
        DB::table('rates')->insert([
           'id' => (string) Str::uuid(),
           'coin_id' => $coin->id,
           'rate' => 0.0045,
           'source' => 'gemini',
           'created_at' => Carbon::create(2022, 6, 1, 0, 0, 0, 'America/New_York')
       ]);

        // RLY

        //Fetch coin
        $coin = DB::table('coin_metadata')
                  ->where('symbol', '=', 'RLY')
                  ->first();

        // Update old rate
        DB::table('rates')
          ->where('coin_id', '=', $coin->id)
          ->update(['rate' => 0.0422]);

        //insert new rate
        DB::table('rates')->insert([
           'id' => (string) Str::uuid(),
           'coin_id' => $coin->id,
           'rate' => 0.0454,
           'source' => 'gemini',
           'created_at' => Carbon::create(2022, 6, 1, 0, 0, 0, 'America/New_York')
       ]);

        // SNX

        //Fetch coin
        $coin = DB::table('coin_metadata')
                  ->where('symbol', '=', 'SNX')
                  ->first();

        // Update old rate
        DB::table('rates')
          ->where('coin_id', '=', $coin->id)
          ->update(['rate' => 0.0253]);

        //insert new rate
        DB::table('rates')->insert([
           'id' => (string) Str::uuid(),
           'coin_id' => $coin->id,
           'rate' => 0.0275,
           'source' => 'gemini',
           'created_at' => Carbon::create(2022, 6, 1, 0, 0, 0, 'America/New_York')
       ]);

        // TOKE

        //Fetch coin
        $coin = DB::table('coin_metadata')
                  ->where('symbol', '=', 'TOKE')
                  ->first();

        // Update old rate
        DB::table('rates')
          ->where('coin_id', '=', $coin->id)
          ->update(['rate' => 0.0224, 'created_at' => Carbon::create(2022, 6, 1, 0, 0, 0, 'America/New_York')]);

        // UMA

        //Fetch coin
        $coin = DB::table('coin_metadata')
                  ->where('symbol', '=', 'UMA')
                  ->first();

        // Update old rate
        DB::table('rates')
          ->where('coin_id', '=', $coin->id)
          ->update(['rate' => 0.0050]);

        //insert new rate
        DB::table('rates')->insert([
           'id' => (string) Str::uuid(),
           'coin_id' => $coin->id,
           'rate' => 0.0045,
           'source' => 'gemini',
           'created_at' => Carbon::create(2022, 6, 1, 0, 0, 0, 'America/New_York')
       ]);

        // ZEC

        //Fetch coin
        $coin = DB::table('coin_metadata')
                  ->where('symbol', '=', 'UMA')
                  ->first();

        // Update old rate
        DB::table('rates')
          ->where('coin_id', '=', $coin->id)
          ->update(['rate' => 0.0050]);

        //insert new rate
        DB::table('rates')->insert([
           'id' => (string) Str::uuid(),
           'coin_id' => $coin->id,
           'rate' => 0.0045,
           'source' => 'gemini',
           'created_at' => Carbon::create(2022, 6, 1, 0, 0, 0, 'America/New_York')
       ]);

        // BAT

        //Fetch coin
        $coin = DB::table('coin_metadata')
                  ->where('symbol', '=', 'BAT')
                  ->first();

        // Update old rate
        DB::table('rates')
          ->where('coin_id', '=', $coin->id)
          ->update(['rate' => 0.0175, 'created_at' => Carbon::create(2022, 1, 1, 0, 0, 0, 'America/New_York')]);

        //insert new rate
        DB::table('rates')->insert([
           'id' => (string) Str::uuid(),
           'coin_id' => $coin->id,
           'rate' => 0.0101,
           'source' => 'gemini',
           'created_at' => Carbon::create(2022, 2, 1, 0, 0, 0, 'America/New_York')
       ]);

    }
}
