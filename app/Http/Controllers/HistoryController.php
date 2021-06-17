<?php

namespace App\Http\Controllers;

use App\Models\CoinMetadata;
use App\Models\ProviderMetadata;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function showHistoryByProviderAndCoinView(string $provider, string $coin)
    {
        $providerMetaData = ProviderMetadata::where('name', $provider)->first();
        if (!$providerMetaData) {
            abort(404);
        }

        $coinMetaData = CoinMetadata::where('symbol', $coin)->first();
        if (!$coinMetaData) {
            abort(404);
        }

        return view('history.by-provider', ['providerMetaData' => $providerMetaData, 'coinMetaData' => $coinMetaData]);

    }
}
