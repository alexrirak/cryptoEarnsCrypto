<?php

namespace App\Http\Controllers;

use App\Models\ProviderMetadata;
use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RatesController extends Controller
{
    public function getRates(Request $request, $source)
    {
        // If we receive a user id check that the user exists and if so return their favorites status with the data
        if ($request->query('user')) {
            $user = \App\Models\User::where('id', '=', $request->query('user'))
                                    ->get();

            if (count($user) == 1) {
                $user = $user[0];
                return Rate::join('coin_metadata', 'rates.coin_id', '=', 'coin_metadata.id')
                           ->select(
                               DB::raw('Max(coin_metadata.symbol) as symbol'),
                               DB::raw('(SELECT MAX(created_at) FROM rates rdt WHERE rdt.coin_id = rates.coin_id AND rdt.source = rates.source LIMIT 1) as latest_date'),
                               DB::raw('(SELECT rate FROM rates crr WHERE crr.coin_id = rates.coin_id AND crr.created_at = latest_date AND crr.source = rates.source LIMIT 1) as latest_rate'),
                               DB::raw('(SELECT special_rate FROM rates crsr WHERE crsr.coin_id = rates.coin_id AND crsr.created_at = latest_date AND crsr.source = rates.source LIMIT 1) as latest_special_rate'),
                               DB::raw('(SELECT MAX(created_at) FROM rates rdt2 WHERE rdt2.coin_id = rates.coin_id AND rdt2.created_at != latest_date AND rdt2.source = rates.source LIMIT 1) as prior_date'),
                               DB::raw('(SELECT rate FROM rates crr2 WHERE crr2.coin_id = rates.coin_id AND crr2.created_at = prior_date AND crr2.source = rates.source LIMIT 1) as prior_rate'),
                               DB::raw('(SELECT special_rate FROM rates crsr2 WHERE crsr2.coin_id = rates.coin_id AND crsr2.created_at = prior_date AND crsr2.source = rates.source LIMIT 1) as prior_special_rate'),
                               DB::raw('Max(coin_metadata.name) as name'),
                               DB::raw('Max(coin_metadata.image) as image'),
                               DB::raw('(uf.coin_id is not NULL) as favorite'),
                               DB::raw('(ua.coin_id is not NULL) as alert'),
                               'rates.source'
                           )
                           ->leftJoin('user_favorites as uf', function ($join) use ($user) {
                               $join->on('uf.coin_id', '=', 'rates.coin_id')
                                    ->where('uf.user_id', '=', $user->id);
                           })
                           ->leftJoin('user_alerts as ua', function ($join) use ($user) {
                               $join->on('ua.coin_id', '=', 'rates.coin_id')
                                    ->where('ua.user_id', '=', $user->id);
                           })
                           ->where('rates.source', '=', $source)
                           ->groupBy('rates.coin_id', 'rates.source', 'uf.coin_id', 'ua.coin_id')
                           ->get();
            }

        }

        return Rate::join('coin_metadata', 'rates.coin_id', '=', 'coin_metadata.id')
                   ->select(
                       DB::raw('Max(coin_metadata.symbol) as symbol'),
                       DB::raw('(SELECT MAX(created_at) FROM rates rdt WHERE rdt.coin_id = rates.coin_id AND rdt.source = rates.source LIMIT 1) as latest_date'),
                       DB::raw('(SELECT rate FROM rates crr WHERE crr.coin_id = rates.coin_id AND crr.created_at = latest_date AND crr.source = rates.source LIMIT 1) as latest_rate'),
                       DB::raw('(SELECT special_rate FROM rates crsr WHERE crsr.coin_id = rates.coin_id AND crsr.created_at = latest_date AND crsr.source = rates.source LIMIT 1) as latest_special_rate'),
                       DB::raw('(SELECT MAX(created_at) FROM rates rdt2 WHERE rdt2.coin_id = rates.coin_id AND rdt2.created_at != latest_date AND rdt2.source = rates.source LIMIT 1) as prior_date'),
                       DB::raw('(SELECT rate FROM rates crr2 WHERE crr2.coin_id = rates.coin_id AND crr2.created_at = prior_date AND crr2.source = rates.source LIMIT 1) as prior_rate'),
                       DB::raw('(SELECT special_rate FROM rates crsr2 WHERE crsr2.coin_id = rates.coin_id AND crsr2.created_at = prior_date AND crsr2.source = rates.source LIMIT 1) as prior_special_rate'),
                       DB::raw('Max(coin_metadata.name) as name'),
                       DB::raw('Max(coin_metadata.image) as image'),
                       'rates.source'
                   )
                   ->where('rates.source', '=', $source)
                   ->groupBy('rates.coin_id', 'rates.source')
                   ->get();
    }

    public function getAllRates(Request $request)
    {
        return Rate::join('coin_metadata', 'rates.coin_id', '=', 'coin_metadata.id')
                   ->select(
                       DB::raw('Max(coin_metadata.symbol) as symbol'),
                       DB::raw('(SELECT MAX(created_at) FROM rates rdt WHERE rdt.coin_id = rates.coin_id AND rdt.source = rates.source LIMIT 1) as latest_date'),
                       DB::raw('(SELECT rate FROM rates crr WHERE crr.coin_id = rates.coin_id AND crr.created_at = latest_date AND crr.source = rates.source LIMIT 1) as latest_rate'),
                       DB::raw('(SELECT special_rate FROM rates crsr WHERE crsr.coin_id = rates.coin_id AND crsr.created_at = latest_date AND crsr.source = rates.source LIMIT 1) as latest_special_rate'),
                       DB::raw('(SELECT MAX(created_at) FROM rates rdt2 WHERE rdt2.coin_id = rates.coin_id AND rdt2.created_at != latest_date AND rdt2.source = rates.source LIMIT 1) as prior_date'),
                       DB::raw('(SELECT rate FROM rates crr2 WHERE crr2.coin_id = rates.coin_id AND crr2.created_at = prior_date AND crr2.source = rates.source LIMIT 1) as prior_rate'),
                       DB::raw('(SELECT special_rate FROM rates crsr2 WHERE crsr2.coin_id = rates.coin_id AND crsr2.created_at = prior_date AND crsr2.source = rates.source LIMIT 1) as prior_special_rate'),
                       DB::raw('Max(coin_metadata.name) as name'),
                       DB::raw('Max(coin_metadata.image) as image'),
                       'rates.source'
                   )
                   ->groupBy('rates.coin_id', 'rates.source')
                   ->get();
    }

    public function showRatesView(string $provider)
    {

        $providerMetaData = ProviderMetadata::where('name', $provider)->first();
        if (!$providerMetaData) {
            abort(404);
        }
        $diff = DB::select((DB::raw('SELECT TIMESTAMPDIFF(SECOND,"' . $providerMetaData->updated_at . '",NOW()) AS diff; ')))[0];

        $diff = $this->convertSeconds($diff->diff);

        return view('rates', ['provider' => $provider, 'providerMetaData' => $providerMetaData, 'diff' => $diff]);

    }

    private function convertSeconds(int $seconds)
    {
        if ($seconds < 60) {
            $time = $seconds;
            $time_val = "second";
        } else if ($seconds >= 60 && $seconds < 3600) { # hr
            $time = floor($seconds / 60);
            $time_val = "minute";
        } else if ($seconds >= 3600 && $seconds < 86400) { # day
            $time = floor($seconds / 3600);
            $time_val = "hour";
        } else if ($seconds >= 86400 && $seconds < 604800) { # week
            $time = floor($seconds / 86400);
            $time_val = "day";
        } else if ($seconds >= 604800) {
            $time = floor($seconds / 604800);
            $time_val = "week";
        }
        if ($time > 1) $time_val .= 's';
        return "$time $time_val";
    }
}
