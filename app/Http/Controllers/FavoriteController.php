<?php

namespace App\Http\Controllers;

use App\Models\CoinMetadata;
use App\Models\ProviderMetadata;
use App\Models\Rate;
use App\Models\UserFavorite;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FavoriteController extends Controller
{
    public function addFavorite(Request $request, $provider, $coin)
    {

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


        return response("", 201);

    }

    public function deleteFavorite(Request $request, $provider, $coin)
    {

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

        if (count($existing) != 1) {
            abort(400);
        }

        $existing[0]->delete();

        return response("", 204);

    }

    public function addAll(Request $request, string $provider)
    {

        $provider = ProviderMetadata::where('name', $provider)->get();

        if (count($provider) == 0) {
            abort(400);
        }

        $missingCoins = Rate::select('coin_id')
                            ->distinct()
                            ->where('source', $provider[0]->name)
                            ->whereRaw("coin_id not in (select distinct(coin_id) from user_favorites where user_id = ? and source_id = ?)", [$request->user()->id, $provider[0]->id])
                            ->get();

        $data = [];
        foreach ($missingCoins as $coin) {
            $data[] = [
                'id' => (string)Str::uuid(),
                'user_id' => $request->user()->id,
                'coin_id' => $coin->coin_id,
                'source_id' => $provider[0]->id
            ];
        }

        if (count($data) > 0) {
            UserFavorite::insert($data);
        }

        return response("", 201);

    }

    public function deleteAll(Request $request, string $provider)
    {

        $provider = ProviderMetadata::where('name', $provider)->get();

        if (count($provider) == 0) {
            abort(400);
        }

        UserFavorite::where('source_id', '=', $provider[0]->id)
                    ->where('user_id', '=', $request->user()->id)
                    ->delete();

        return response("", 204);

    }
}
