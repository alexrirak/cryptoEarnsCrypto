<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RatesController extends Controller
{
    public function getRates(Request $request, $source) {
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
                               'rates.source'
                           )
                           ->leftJoin('user_favorites as uf', function($join) use ($user) {
                               $join->on('uf.coin_id','=','rates.coin_id')
                                    ->where('uf.user_id', '=', $user->id);
                           })
                           ->where('rates.source', '=', $source)
                           ->groupBy('rates.coin_id', 'rates.source', 'uf.coin_id')
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

    public function getAllRates(Request $request) {
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
}
