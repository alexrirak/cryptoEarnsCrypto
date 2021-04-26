<?php

namespace App\Http\Controllers;

use App\Models\CoinMetadata;
use App\Models\ProviderMetadata;
use App\Models\UserNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function addNotification(Request $request, $provider, $coin) {

        $provider = ProviderMetadata::where('name', $provider)->get();

        if (count($provider) == 0) {
            abort(400);
        }

        $coin = CoinMetadata::where('symbol', $coin)->get();

        if (count($coin) == 0) {
            abort(400);
        }

        $existing = UserNotification::where('user_id', $request->user()->id)
                                    ->where('coin_id', $coin[0]->id)
                                    ->where('source_id', $provider[0]->id)
                                    ->get();

        if (count($existing) != 0) {
            abort(400);
        }

        $notification = new UserNotification;
        $notification->user_id = $request->user()->id;
        $notification->coin_id = $coin[0]->id;
        $notification->source_id = $provider[0]->id;
        $notification->save();


        return response("",201);

    }

    public function deleteNotification(Request $request, $provider, $coin) {

        $provider = ProviderMetadata::where('name', $provider)->get();

        if (count($provider) == 0) {
            abort(400);
        }

        $coin = CoinMetadata::where('symbol', $coin)->get();

        if (count($coin) == 0) {
            abort(400);
        }

        $existing = UserNotification::where('user_id', $request->user()->id)
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
