<?php

use App\Models\CoinMetadata;
use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/rate-stats', function () {
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
})->name('rate-stats');

Route::get('/rate-stats/{source}', function ($source) {
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
});
