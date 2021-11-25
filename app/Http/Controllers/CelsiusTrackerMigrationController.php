<?php

namespace App\Http\Controllers;

use App\Mail\CTAccountMigrgationSuccess;
use App\Models\CoinMetadata;
use App\Models\ProviderMetadata;
use App\Models\User;
use App\Models\UserAlert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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

        $oldSubscriptions = DB::connection('coinTrackerMySQL')
                              ->table('coinAlerts')
                              ->select('coin')
                              ->where('email', '=', $emailId)
                              ->where('active', '=', 1)
                              ->get()
                              ->map(function ($i) {
                                  return $i->coin;
                              });

        return CoinMetadata::whereIn('symbol', $oldSubscriptions)->get();

    }

    public function landing()
    {
        return view('celsiusTracker.landing');
    }

    public function migrateView(string $emailId)
    {
        return view('celsiusTracker.migrate', ['subscriptions' => $this->subscriptionList($emailId), 'emailId' => $emailId]);
    }

    // pulls data from celsius tracker and migrates to crypto earns crypto
    public function migrateUser(string $emailId)
    {

        $user = User::where(['email' => $emailId])->first();

        if ($user) {
            // user already exists
            abort(400, "User already exists");
        }

        Log::info(sprintf("[CT Migration] Migrating Data for: %s", $emailId));

        //create a new user
        $user = User::create([
                                 'name' => "User",
                                 'email' => $emailId,
                                 'provider_id' => $emailId,
                                 'provider' => "CelsiusTracker",
                             ]);

        //fetch the user's old subscriptions
        $coins = $this->subscriptionList($emailId);

        // provider is always celsius
        $provider = ProviderMetadata::where("name", "=", "Celsius")->first();

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

        Log::info(sprintf("[CT Migration] Subscriptions migrated for: %s", $emailId));

        //delete old subscriptions
        $response = Http::delete('https://' . env('CT_API_HOST') . "/unsubscribe/" . bin2hex($emailId));

        if ($response->successful()) {
            Log::info(sprintf("[CT Migration] Deleted old subscriptions for: %s", $emailId));
        } else {
            Log::warning(sprintf("[CT Migration] Failed to delete old subscriptions for: %s", $emailId));
        }

        Mail::to($user->email)
            ->send(new CTAccountMigrgationSuccess());

        Log::info(sprintf("[CT Migration] Sent Email to: %s", $emailId));

        return response($coins, 201);


    }
}
