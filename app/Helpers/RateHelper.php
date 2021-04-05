<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class RateHelper
{
    /**
     * Returns the latest rates from the database based on a given source
     * @param string $source the string representation of the source
     * @return array
     */
    public static function getRates(string $source) {
        return DB::table(DB::raw('rates r'))
        ->select('cm.symbol','r.coin_id','r.rate','r.special_rate')
        ->leftJoin(DB::raw('rates rr'), function ($join) {
            $join->on('r.coin_id', '=', 'rr.coin_id');
            $join->on('r.source', '=', 'rr.source');
            $join->on('r.created_at', '<', 'rr.created_at');
        })
        ->leftJoin(DB::raw('coin_metadata cm'), 'r.coin_id', '=', 'cm.id')
        ->where('rr.created_at', '=', NULL)
        ->where('r.source', '=', $source)
        ->get()
        ->toArray();
    }

    /**
     * Given an array of coin rates, filters out the row for a specific coin
     * @param array $ratesArr array of con data, obtained from getRates
     * @param string $coin string representaion of the coin to retreive
     * @return array
     */
    public static function filterRatesArray($ratesArr, $coin) {
        return Arr::where($ratesArr, function ($value, $key) use (&$coin) {
            return $value->symbol == $coin;
        });
    }


    /**
     * Converts APR to APY with ((1+(r/n))^(n))-1 where r is rate and n is compunding periods
     * @param float $apr Interest rate to convert
     * @param int $compundingPeriods number of compounding periods per year
     * @return float
     */
    public static function aprToApy(float $apr, int $compundingPeriods) {
        return pow((1 + ($apr/$compundingPeriods)), $compundingPeriods)-1;
    }

    /**
     * Converts in-kind to cel rate by multiplying by conversion rate
     * @param float $apr Interest rate to convert
     * @return float
     */
    public static function inKindToCel(float $apr) {
        return $apr * (float)config('sources.celsius_special_rate');
    }
}
