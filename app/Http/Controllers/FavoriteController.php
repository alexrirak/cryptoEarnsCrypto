<?php

namespace App\Http\Controllers;

use App\Models\CoinMetadata;
use App\Models\ProviderMetadata;
use App\Models\UserFavorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function addFavorite(Request $request, $provider, $coin) {

        $provider = ProviderMetadata::where('name', $provider)->get();

        if (count($provider) == 0) {
            abort(400);
        }

        $coin = CoinMetadata::where('symbol', $coin)->get();

        if (count($coin) == 0) {
            abort(400);
        }

        $existing = UserFavorite::where('user_id', $request->user()->id)
                                ->where('coin_id', $coin[0]->id)
                                ->where('source_id', $provider[0]->id)
                                ->get();

        if (count($existing) != 0) {
            abort(400);
        }

        $favorite = new UserFavorite;
        $favorite->user_id = $request->user()->id;
        $favorite->coin_id = $coin[0]->id;
        $favorite->source_id = $provider[0]->id;
        $favorite->save();



        return response("",201);

    }
}
