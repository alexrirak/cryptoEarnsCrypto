<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function showAdminDashboardView()
    {

        $usersCount = DB::table('users')->count();
        $alertsCount = DB::table('user_alerts')->count();
        $favoritesCount = DB::table('user_favorites')->count();

        return view('admin.dashboard',  ['usersCount' => $usersCount, 'alertsCount' => $alertsCount, 'favoritesCount' => $favoritesCount]);
    }
}
