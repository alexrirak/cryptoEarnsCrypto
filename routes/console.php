<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

use App\Helpers\RateHelper;
use App\Helpers\CoinHelper;
use App\Models\Rate;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/


/**
 * Queries the Celsius API to get the latest rates nad inserts them into the DB is they have been udpated
 * Also does conversion and saves 'Cel' rate
 */
Artisan::command('getCelsiusRates', function () {

    $url = Str::lower(config('app.env'))=='production' ? config('sources.celsius_url') : config('sources.celsius_staging_url') ;
    $response = Http::get($url);

    if ($response->successful()) {
        $rates = $response->json()['interestRates'];

        $currentRates = RateHelper::getRates("celsius");


        $data=[];
        foreach($rates as $rate){

            // Grab current info and get the conversions out of the way
            $currRate = RateHelper::filterRatesArray($currentRates, $rate["coin"]);
            $newApyRate = round(RateHelper::aprToApy((float)$rate["rate"],52),4);
            $newCelApyRate = round(RateHelper::aprToApy(RateHelper::inKindToCel((float)$rate["rate"]),52),4);

            // if the count is not 1 then this is a new coin we dont have rates for yet
            if(count($currRate) != 1) {
                Log::info("[Celsius] New coin available: " . $rate["coin"]);

                // Get the coin id for this coin if it already exists
                $coinId = CoinHelper::getCoinBySymbolOrName($rate["coin"],$rate["currency"]["name"]);

                // if it doesnt exsist we need to create it
                if (!$coinId) {
                    Log::notice("[Celsius] Coin doesnt exist, creating it: " . json_encode($rate));
                    $coinId = (string) Str::uuid();

                }


                // TODO
                continue;
            }

            // we have an array with one item, so reference the item directly
            $currRate = Arr::first($currRate, function() {return true;});

            // if the rate has changed prep the data we will insert into db
            if ($currRate->rate != $newApyRate) {

                Log::info("[Celsius] Updated rate available for " . $currRate->symbol);
                Log::debug("[Celsius] Old Rate:" . $currRate->rate . " New Rate: " . $newApyRate);

                $data[] = [
                    'id' => (string) Str::uuid(),
                    'coin_id' => $currRate->coin_id,
                    'rate' => $newApyRate,
                    'special_rate' => $newCelApyRate,
                    'source' => config('sources.celsius_source_id')
                  ];
            } else {
                Log::debug("[Celsius] No update needed for " . $currRate->symbol);
            }

        }

        // insert the data in one action
        Log::info("[Celsius] Inserting generated data");
        Rate::insert($data);


    } else {
        Log::critical("[Celsius] API call for rates failed! Error Code: " . $response->status());
    }



})->purpose('Fetch latest rates from Celsius website');

Artisan::command('test', function () {
    $temp = CoinHelper::getCoinBySymbolOrName("ETH1","ethereum");
    print($temp);

    // $temp = CoinHelper::getCoinByName("ethereum");
    // print($temp);
});
