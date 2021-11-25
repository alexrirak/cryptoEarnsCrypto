<?php

namespace App\Http\Controllers;

use App\Models\CoinMetadata;
use App\Models\ProviderMetadata;
use App\Models\User;
use App\Models\UserAlert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CelsiusTrackerMigrationController extends Controller
{
    public function userCheck(string $emailId)
    {
        $existingUser = User::where(['email' => $emailId])->first();

        if ($existingUser) {
            // user already exists
            abort(400, "User already exists");
        }

        $userCheck = DB::connection('coinTrackerMySQL')
                       ->table('coinAlerts')
                       ->select('email')
                       ->where('email', '=', $emailId)
                       ->where('active', '=', 1)
                       ->count();

        return response($userCheck, 200);
    }

    private function subscriptionList(string $emailId)
    {

        return DB::connection('coinTrackerMySQL')
                 ->table('coinAlerts')
                 ->select('coin')
                 ->where('email', '=', $emailId)
                 ->where('active', '=', 1)
                 ->get()
                 ->map(function ($i) {
                     return $i->coin;
                 });

    }

    public function landing()
    {
        return view('celsiusTracker.landing');
    }

    public function migrateView(string $emailId)
    {
        return view('celsiusTracker.migrate', ['subscriptions' => $this->subscriptionList($emailId), 'emailId' => $emailId]);
    }

    public function migrateUser(string $emailId)
    {

        $user = User::where(['email' => $emailId])->first();

        if ($user) {
            // user already exists
            abort(400, "User already exists");
        }

        //create a new user
        $user = User::create([
                                 'name' => "User",
                                 'email' => $emailId,
                                 'provider_id' => $emailId,
                                 'provider' => "CelsiusTracker",
                             ]);

        //fetch the user's old subscriptions
        $oldSubscriptions = $this->subscriptionList($emailId);

        // provider is always celsius
        $provider = ProviderMetadata::where("name", "=", "Celsius")->first();

        //convert old subscriptions into coin metadatas
        $coins = CoinMetadata::whereIn('symbol', $oldSubscriptions)->get();

        // prepare data for alerts to do a bulk insert
        $alerts = [];
        foreach ($coins as $coin) {
            $alerts[] = [
                'id' => (string)Str::uuid(),
                'user_id' => $user->id,
                'coin_id' => $coin->id,
                'source_id' => $provider->id,
                'use_special' => 0
            ];
        }

        // bulk insert
        if (count($alerts) > 0) {
            UserAlert::insert($alerts);
        }

        return response($coins, 201);


    }
}
