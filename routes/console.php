<?php

use App\Events\RatesProcessed;
use App\Helpers\CoinHelper;
use App\Helpers\RateHelper;
use App\Models\CoinMetadata;
use App\Models\ProviderMetadata;
use App\Models\Rate;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
 * Queries the Gemini Website to get the latest rates and inserts them into the DB if they have been updated
 */
Artisan::command('getGeminiRates', function () {

    // Find and extract the 'build' id so that we can form the data url
    $url = config('sources.gemini_earn_url');
    $web_response = Http::get($url);
    $data_url = Str::replace('%%ID%%',
                             Str::betweenFirst($web_response->body(), '"buildId":"', '"'),
                             config('sources.gemini_data_url'));

    $response = Http::get($data_url);

    if ($response->successful()) {
        $rates = $response->json()['pageProps']['earnRates']['interestRates'];

        $currentRates = RateHelper::getRates("gemini");


        $data = [];
        foreach ($rates as $rate) {

            // Grab current info and get the conversions out of the way
            $currRate = RateHelper::filterRatesArray($currentRates, $rate["symbol"]);
            $newApyRate = $rate["apy"];

            // if the count is not 1 then this is a new coin we dont have rates for yet
            if (count($currRate) != 1) {
                Log::info("[Gemini] New coin available: " . $rate["symbol"]);

                // Get the coin id for this coin if it already exists
                $coinId = CoinHelper::getCoinBySymbolOrName($rate["symbol"], $rate["value"]);

                // if it doesnt exist we need to create it
                if (!$coinId) {
                    Log::notice("[Gemini] Coin doesnt exist");
                    $coinId = (string)Str::uuid();

                    $coinMetadata = new CoinMetadata;
                    $coinMetadata->id = $coinId;
                    $coinMetadata->name = $rate["value"];
                    $coinMetadata->symbol = $rate["symbol"];
                    $coinMetadata->image = "https://www.gemini.com/images/currencies/icons/default/" . Str::lower($rate["symbol"]) .".svg";

                    Log::notice("[Gemini] Creating: " . json_encode($coinMetadata));
                    $coinMetadata->save();

                    //TODO: send notification (at least to myself) that new rate is available

                }

                // Insert the rate for the coin
                $data[] = [
                    'id' => (string)Str::uuid(),
                    'coin_id' => $coinId,
                    'rate' => $newApyRate,
                    'source' => config('sources.gemini_source_id')
                ];

                // No need to continue
                continue;
            }

            // we have an array with one item, so reference the item directly
            $currRate = Arr::first($currRate, function () {
                return true;
            });

            // if the rate has changed prep the data we will insert into db
            if ($currRate->rate != $newApyRate) {

                Log::info("[Gemini] Updated rate available for " . $currRate->symbol);
                Log::debug("[Gemini] Old Rate:" . $currRate->rate . " New Rate: " . $newApyRate);

                $data[] = [
                    'id' => (string)Str::uuid(),
                    'coin_id' => $currRate->coin_id,
                    'rate' => $newApyRate,
                    'source' => config('sources.gemini_source_id')
                ];
            } else {
                Log::debug("[Gemini] No update needed for " . $currRate->symbol);
            }

        }

        // insert the data in one action
        if (count($data) > 0) {
            Log::info("[Gemini] Inserting updated data");
            Rate::insert($data);
        } else {
            Log::info("[Gemini] No updated data");
        }

        RatesProcessed::dispatch("gemini");

        // We want to have a record of when we last updated rates
        $provider = ProviderMetadata::where('name','=', 'Gemini')->first();
        $provider->updated_at = DB::raw("now()");
        $provider->save();


    } else {
        Log::critical("[Gemini] API call for rates failed! Error Code: " . $response->status());
    }


})->purpose('Fetch latest rates from Gemini website');

/**
 * Queries the Celsius API to get the latest rates nad inserts them into the DB is they have been updated
 * Also does conversion and saves 'Cel' rate
 */
Artisan::command('getCelsiusRates', function () {

    $url = Str::lower(config('app.env')) == 'production' ? config('sources.celsius_url') : config('sources.celsius_staging_url');
    $response = Http::get($url);

    if ($response->successful()) {
        $rates = $response->json()['interestRates'];

        $currentRates = RateHelper::getRates("celsius");


        $data = [];
        foreach ($rates as $rate) {

            // Grab current info and get the conversions out of the way
            $currRate = RateHelper::filterRatesArray($currentRates, $rate["coin"]);
            $newApyRate = round(RateHelper::aprToApy((float)$rate["rate"], 52), 4);
            $newCelApyRate = Str::lower($rate["coin"]) == "cel" ? $newApyRate : round(RateHelper::aprToApy(RateHelper::inKindToCel((float)$rate["rate"]), 52), 4);

            // if the count is not 1 then this is a new coin we dont have rates for yet
            if (count($currRate) != 1) {
                Log::info("[Celsius] New coin available: " . $rate["coin"]);

                // Get the coin id for this coin if it already exists
                $coinId = CoinHelper::getCoinBySymbolOrName($rate["coin"], $rate["currency"]["name"]);

                // if it doesnt exsist we need to create it
                if (!$coinId) {
                    Log::notice("[Celsius] Coin doesnt exist");
                    $coinId = (string)Str::uuid();

                    $coinMetadata = new CoinMetadata;
                    $coinMetadata->id = $coinId;
                    $coinMetadata->name = $rate["currency"]["name"];
                    $coinMetadata->symbol = $rate["coin"];
                    $coinMetadata->image = $rate["currency"]["image_url"];

                    Log::notice("[Celsius] Creating: " . json_encode($coinMetadata));
                    $coinMetadata->save();

                    //TODO: send notification (at least to myself) that new rate is available

                }

                // Insert the rate for the coin
                $data[] = [
                    'id' => (string)Str::uuid(),
                    'coin_id' => $coinId,
                    'rate' => $newApyRate,
                    'special_rate' => $newCelApyRate,
                    'source' => config('sources.celsius_source_id')
                ];

                // No need to continue
                continue;
            }

            // we have an array with one item, so reference the item directly
            $currRate = Arr::first($currRate, function () {
                return true;
            });

            // if the rate has changed prep the data we will insert into db
            if ($currRate->rate != $newApyRate) {

                Log::info("[Celsius] Updated rate available for " . $currRate->symbol);
                Log::debug("[Celsius] Old Rate:" . $currRate->rate . " New Rate: " . $newApyRate);

                $data[] = [
                    'id' => (string)Str::uuid(),
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
        if (count($data) > 0) {
            Log::info("[Celsius] Inserting updated data");
            Rate::insert($data);
        } else {
            Log::info("[Celsius] No updated data");
        }

        RatesProcessed::dispatch("celsius");

        // We want to have a record of when we last updated rates
        $provider = ProviderMetadata::where('name','=', 'Celsius')->first();
        $provider->updated_at = DB::raw("now()");
        $provider->save();


    } else {
        Log::critical("[Celsius] API call for rates failed! Error Code: " . $response->status());
    }


})->purpose('Fetch latest rates from Celsius website');
