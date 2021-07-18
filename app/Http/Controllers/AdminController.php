<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function showUserStatView()
    {

        $usersCount = DB::table('users')->count();
        $alertsCount = DB::table('user_alerts')->count();
        $favoritesCount = DB::table('user_favorites')->count();

        $coinSymbols = DB::table('coin_metadata')->pluck('symbol');
        $providerIds = DB::table('provider_metadata')->pluck('id');

        $coinArrayTemplate = array_fill_keys(array_keys(array_flip($coinSymbols->toArray())), 0);

        $alertsCountByCoin = $this->getCounts(function ($source) {
            return $this->getAlertCountsBySource($source);
        }, $providerIds, $coinArrayTemplate);

        $favoritesCountByCoin = $this->getCounts(function ($source) {
            return $this->getFavoriteCountsBySource($source);
        }, $providerIds, $coinArrayTemplate);

        return view('admin.dashboard', ['usersCount' => $usersCount,
                                        'alertsCount' => $alertsCount,
                                        'favoritesCount' => $favoritesCount,
                                        'alertsCountByCoin' => $alertsCountByCoin,
                                        'favoritesCountByCoin' => $favoritesCountByCoin]);
    }

    private function getCounts($dataRetrieval, $providerIds, $coinArrayTemplate)
    {
        $countByCoin = array();
        foreach ($providerIds as $providerId) {

            $result = $dataRetrieval($providerId);
            if ($result->isNotEmpty()) {

                $providerName = $result->first()->source;

                $countByCoin[$providerName] = $coinArrayTemplate;

                foreach ($result as $coin) {
                    $countByCoin[$providerName][$coin->symbol] = $coin->counter;
                }
            }
        }

        return $countByCoin;
    }

    private function getAlertCountsBySource(string $source_id): \Illuminate\Support\Collection
    {
        $result = DB::table('coin_metadata')
                    ->select('coin_metadata.symbol',
                             DB::raw('pm.name as source'),
                             DB::raw('count(distinct(ua.user_id)) as counter'))
                    ->leftJoin('user_alerts as ua', 'coin_metadata.id', '=', 'ua.coin_id')
                    ->leftJoin('provider_metadata as pm', 'ua.source_id', '=', 'pm.id')
                    ->groupBy('coin_metadata.symbol', 'ua.source_id', 'pm.name')
                    ->orderBy('coin_metadata.symbol')
                    ->where('ua.source_id', $source_id)
                    ->get();

        return $result;
    }

    private function getFavoriteCountsBySource(string $source_id): \Illuminate\Support\Collection
    {
        $result = DB::table('coin_metadata')
                    ->select('coin_metadata.symbol',
                             DB::raw('pm.name as source'),
                             DB::raw('count(distinct(uf.user_id)) as counter'))
                    ->leftJoin('user_favorites as uf', 'coin_metadata.id', '=', 'uf.coin_id')
                    ->leftJoin('provider_metadata as pm', 'uf.source_id', '=', 'pm.id')
                    ->groupBy('coin_metadata.symbol', 'uf.source_id', 'pm.name')
                    ->orderBy('coin_metadata.symbol')
                    ->where('uf.source_id', $source_id)
                    ->get();

        return $result;
    }
}
