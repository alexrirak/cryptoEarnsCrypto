<?php

namespace App\Http\Controllers;

use App\Events\DeleteUser;
use App\Models\Rate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function showProfile()
    {
        $user = User::select('users.name',
                             'users.email',
                             'users.created_at as member_since',
                             DB::raw('count(Distinct(uf.coin_id)) as favorites'),
                             DB::raw('count(Distinct(ua.coin_id)) as alerts'))
                    ->leftJoin('user_favorites as uf', 'users.id', '=', 'uf.user_id')
                    ->leftJoin('user_alerts as ua', 'users.id', '=', 'ua.user_id')
                    ->where('users.id', '=', Auth::user()->id)
                    ->groupBy('users.id', 'users.name', 'users.email', 'users.created_at')
                    ->first();

        return view('user.profile', ['user' => $user]);
    }

    public function deleteUser(Request $request)
    {
        $user = User::where('users.id', '=', Auth::user()->id)
                    ->first();

        DeleteUser::dispatch($user);

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return view('user.delete', ['user' => $user]);

    }

    public function showSubscriptions(Request $request)
    {

        $user = User::where('users.id', '=', Auth::user()->id)
                    ->first();

        $data = Rate::select(
            'cmd.name',
            'cmd.symbol',
            'cmd.image',
            'rates.source',
            DB::raw('(uf.coin_id is not NULL) as favorite'),
            DB::raw('(ua.coin_id is not NULL) as alert'),
        )
                    ->leftJoin('provider_metadata as pmd', 'pmd.name', '=', 'rates.source')
                    ->leftJoin('user_favorites as uf', function ($join) use ($user) {
                        $join->on('uf.coin_id', '=', 'rates.coin_id')
                             ->on('uf.source_id', '=', 'pmd.id')
                             ->where('uf.user_id', '=', $user->id);
                    })
                    ->leftJoin('user_alerts as ua', function ($join) use ($user) {
                        $join->on('ua.coin_id', '=', 'rates.coin_id')
                             ->on('ua.source_id', '=', 'pmd.id')
                             ->where('ua.user_id', '=', $user->id);
                    })
                    ->leftJoin('coin_metadata as cmd', 'cmd.id', '=', 'rates.coin_id')
                    ->groupBy('cmd.name', 'cmd.symbol', 'cmd.image', 'rates.source', 'uf.coin_id', 'ua.coin_id')
                    ->orderBy('rates.source', 'asc')
                    ->orderBy('cmd.name', 'asc')
                    ->get()
                    ->mapToGroups(function ($item, $key) {
                        return [$item['source'] => $item];
                    });


        return view('user.subscriptions', ['data' => $data]);
    }
}
