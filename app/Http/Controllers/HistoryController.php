<?php

namespace App\Http\Controllers;

use App\Models\CoinMetadata;
use App\Models\ProviderMetadata;
use App\Models\Rate;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function showHistoryByProviderAndCoinView(Request $request, string $provider, string $coin)
    {
        $providerMetaData = ProviderMetadata::where('name', $provider)->first();
        if (!$providerMetaData) {
            abort(404);
        }

        $coinMetaData = CoinMetadata::where('symbol', $coin)->first();
        if (!$coinMetaData) {
            abort(404);
        }

        $rates = Rate::where('coin_id', $coinMetaData->id)
                     ->where('source', $providerMetaData->name)
                     ->select('rate', 'special_rate', 'created_at')
                     ->orderBy('created_at')
                     ->get();

        if (count($rates) == 0) {
            abort(404);
        } else if (count($rates) < 3) {
            return view('history.by-provider', ['providerMetaData' => $providerMetaData, 'coinMetaData' => $coinMetaData])
                ->withErrors("We do not have enough data points for the requested coin. Please try again at a later time.");
        }

        $labels = [];
        $data = [];
        $specialData = [];
        foreach ($rates as $rate) {
            array_push($labels, $rate->created_at->toJson());
            array_push($data, floatval($rate->rate) * 100);
            array_push($specialData, floatval($rate->special_rate) * 100);
        }

        if (key_exists('specialRate', $request->all())) {
            return view('history.by-provider', ['providerMetaData' => $providerMetaData, 'coinMetaData' => $coinMetaData, 'labels' => $labels, 'data' => $specialData]);
        } else {
            return view('history.by-provider', ['providerMetaData' => $providerMetaData, 'coinMetaData' => $coinMetaData, 'labels' => $labels, 'data' => $data]);
        }

    }
}
