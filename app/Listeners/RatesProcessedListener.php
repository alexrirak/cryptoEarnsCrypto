<?php

namespace App\Listeners;

use App\Events\RatesProcessed;
use App\Events\UserRateNotification;
use App\Models\EmailLog;
use App\Models\ProviderMetadata;
use App\Models\Rate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RatesProcessedListener
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param RatesProcessed $event
     * @return void
     */
    public function handle(RatesProcessed $event)
    {
        Log::info(sprintf("[%s][Rate Update] Handling rate update", $event->provider));

        $provider = ProviderMetadata::where('name', $event->provider)->first();

        if (!$provider) {
            Log::critical(sprintf("Received 'RatesProcessed' event for unknown provider '%s'", $event->provider));
            return;
        }

        $emailLog = EmailLog::where('provider_id', '=', $provider->id)
                            ->where('type', '=', 'UPDATE')
                            ->orderBy('created_at', 'desc')
                            ->first();

        $dbDates = DB::select((DB::raw('Select NOW() AS today, NOW() - INTERVAL 1 DAY AS yesterday')))[0];
        $lastUpdate = $emailLog ? $emailLog->created_at : $dbDates->yesterday;
        $currentDate = $dbDates->today;

        Log::info(sprintf("[%s][Rate Update] Fetching rates from %s to %s", $provider->name, $lastUpdate, $currentDate));

        $usersTonotify = Rate::join('user_alerts', 'rates.coin_id', '=', 'user_alerts.coin_id')
                             ->join('users', 'user_alerts.user_id', '=', 'users.id')
                             ->select('users.id', 'users.name', 'users.email')
                             ->where('user_alerts.source_id', '=', $provider->id)
                             ->where('rates.source', '=', $provider->name)
                             ->whereBetween('rates.created_at', [$lastUpdate, $currentDate])
                             ->groupBy('users.id', 'users.name', 'users.email')
                             ->get();

        Log::debug(sprintf("[%s][Rate Update] Users needing notification: %s", $provider->name, $usersTonotify));

        if (count($usersTonotify) == 0) {
            Log::info(sprintf("[%s][Rate Update] No updates to send since last run", $provider->name));
            return;
        }

        Log::info(sprintf("[%s][Rate Update] Generating notification events", $provider->name));

        foreach ($usersTonotify as $user) {
            Log::debug(sprintf("[%s][Rate Update] Dispatching event for: %s", $provider->name, $user));
            UserRateNotification::dispatch($provider, $user, $lastUpdate, $currentDate);
        }

        Log::info(sprintf("[%s][Rate Update] Updating email log", $provider->name));
        if ($emailLog) {
            $emailLog = $emailLog->replicate();
            $emailLog->id = Str::uuid();
            $emailLog->save();
        } else {
            $emailLog = new EmailLog();
            $emailLog->type = "UPDATE";
            $emailLog->provider_id = $provider->id;
            $emailLog->save();
        }

        Log::info(sprintf("[%s][Rate Update] Rate Update Processed", $provider->name));

    }
}
