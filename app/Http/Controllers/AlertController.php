<?php

namespace App\Http\Controllers;

use App\Models\CoinMetadata;
use App\Models\ProviderMetadata;
use App\Models\UserAlert;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    public function addAlert(Request $request, $provider, $coin) {

        $provider = ProviderMetadata::where('name', $provider)->get();

        if (count($provider) == 0) {
            abort(400);
        }

        $coin = CoinMetadata::where('symbol', $coin)->get();

        if (count($coin) == 0) {
            abort(400);
        }

        $existing = UserAlert::where('user_id', $request->user()->id)
                             ->where('coin_id', $coin[0]->id)
                             ->where('source_id', $provider[0]->id)
                             ->get();

        if (count($existing) != 0) {
            abort(400);
        }

        $notification = new UserAlert;
        $notification->user_id = $request->user()->id;
        $notification->coin_id = $coin[0]->id;
        $notification->source_id = $provider[0]->id;
        $notification->save();


        return response("",201);

    }

    public function deleteAlert(Request $request, $provider, $coin) {

        $provider = ProviderMetadata::where('name', $provider)->get();

        if (count($provider) == 0) {
            abort(400);
        }

        $coin = CoinMetadata::where('symbol', $coin)->get();

        if (count($coin) == 0) {
            abort(400);
        }

        $existing = UserAlert::where('user_id', $request->user()->id)
                             ->where('coin_id', $coin[0]->id)
                             ->where('source_id', $provider[0]->id)
                             ->get();

        if (count($existing) != 1) {
            abort(400);
        }

        $existing[0]->delete();

        return response("",204);

    }
}
