<?php

namespace App\Helpers;

use App\Models\CoinMetadata;

class CoinHelper
{
    /**
     * Retrieve coin metadata based on given symbol
     * @param string $symbol
     * @return string if found, null otherwise
     */
    public static function getCoinBySymbol(string $symbol) {
        $result = CoinMetadata::select('id')
        ->where("symbol","=", $symbol)
        ->get();

        if (count($result) != 1) {
            return null;
        } else {
            return $result[0]->id;
        }
    }

    /**
     * Retrieve coin metadata based on given name
     * @param string $name
     * @return string if found, null otherwise
     */
    public static function getCoinByName(string $name) {
        $result = CoinMetadata::select('id')
        ->where("name","=", $name)
        ->get();

        if (count($result) != 1) {
            return null;
        } else {
            return $result[0]->id;
        }
    }

    /**
     * Retrieve coin metadata based on given id or name. First tries by symbol, then by name if that fails
     * @param string $symbol
     * @param string $name
     * @return string if found, null otherwise
     */
    public static function getCoinBySymbolOrName(string $symbol, string $name) {
        $result = CoinHelper::getCoinBySymbol($symbol);

        if ($result == null) {
            $result = CoinHelper::getCoinByName($name);
        }

        return $result;
    }
}
