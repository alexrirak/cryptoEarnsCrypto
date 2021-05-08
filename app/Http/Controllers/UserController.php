<?php

namespace App\Http\Controllers;

use App\Events\DeleteUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function showProfile() {
        $user = User::select('users.name', 'users.email', 'users.created_at as member_since', DB::raw('count(uf.user_id) as favorites'), DB::raw('count(ua.user_id) as alerts'))
                    ->leftJoin('user_favorites as uf', 'users.id', '=', 'uf.user_id')
                    ->leftJoin('user_alerts as ua', 'users.id', '=', 'ua.user_id')
                    ->where('users.id', '=', Auth::user()->id)
                    ->groupBy('users.id','users.name', 'users.email', 'users.created_at')
                    ->first();

        return view('user.profile', ['user' => $user]);
    }

    public function deleteUser(Request $request) {
        $user = User::where('users.id', '=', Auth::user()->id)
                    ->first();

        DeleteUser::dispatch($user);

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return view('user.delete', ['user' => $user]);

    }
}
