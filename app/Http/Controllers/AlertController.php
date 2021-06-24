<?php

namespace App\Http\Controllers;

use App\Models\CoinMetadata;
use App\Models\ProviderMetadata;
use App\Models\Rate;
use App\Models\UserAlert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AlertController extends Controller
{
    public function addAlert(Request $request, $provider, $coin)
    {

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
        $notification->use_special = 0;
        $notification->save();


        return response("", 201);

    }

    public function deleteAlert(Request $request, $provider, $coin)
    {

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
            if (count($existing) > 1) {
                Log::error("Duplicate subscriptions found for " + $request->user(),['coin_id'=>$coin[0]->id, 'source_id'=> $provider[0]->id]);
            }
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

        $missingCoins = Rate::leftJoin('provider_metadata as pm', 'pm.name', '=', 'rates.source')
                            ->leftJoin('user_alerts as ua', function ($join) use ($request) {
                                $join->on('ua.coin_id', '=', 'rates.coin_id')
                                     ->where('ua.user_id', '=', $request->user()->id);
                            })
                            ->select('rates.coin_id')
                            ->where('pm.id', '=', $provider[0]->id)
                            ->whereNull('ua.user_id')
                            ->get();

        $data = [];
        foreach ($missingCoins as $coin) {
            $data[] = [
                'id' => (string)Str::uuid(),
                'user_id' => $request->user()->id,
                'coin_id' => $coin->coin_id,
                'source_id' => $provider[0]->id,
                'use_special' => 0
            ];
        }

        if (count($data) > 0) {
            UserAlert::insert($data);
        }

        return response("", 201);

    }

    public function deleteAll(Request $request, string $provider)
    {

        $provider = ProviderMetadata::where('name', $provider)->get();

        if (count($provider) == 0) {
            abort(400);
        }

        UserAlert::where('source_id', '=', $provider[0]->id)
                 ->where('user_id', '=', $request->user()->id)
                 ->delete();

        return response("", 204);

    }
}
