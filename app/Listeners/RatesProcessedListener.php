<?php

namespace App\Listeners;

use App\Events\RatesProcessed;
use App\Helpers\EmailHelper;
use App\Models\EmailLog;
use App\Models\ProviderMetadata;
use App\Models\Rate;
use App\Models\UserNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RatesProcessedListener
{

    /**
     * Reference to email helper
     *
     * @var EmailHelper
     */
    private $emailHelper;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(EmailHelper $emailHelper)
    {
        $this->emailHelper = $emailHelper;
    }

    /**
     * Handle the event.
     *
     * @param RatesProcessed $event
     * @return void
     */
    public function handle(RatesProcessed $event)
    {
        Log::info("Handling rate update from [" . $event->provider . "]");

        $provider = ProviderMetadata::where('name', $event->provider)->first();

        if (!$provider) {
            Log::critical(sprintf("Received 'RatesProcessed' event for unknown provider '%s'", $event->provider));
            return;
        }

        $emailLog = EmailLog::where('provider_id', '=', $provider->id)
                            ->where('type', '=', 'UPDATE')
                            ->orderBy('created_at')
                            ->first();

        $lastUpdate = $emailLog ? $emailLog->created_at : date("Y-m-d H:i:s", strtotime("-1 days"));
        $currentDate = date("Y-m-d H:i:s");

        Log::info(sprintf("[%s] Fetching rates from %s to %s", $provider->name, $lastUpdate, $currentDate));

        $usersTonotify = Rate::join('user_notifications', 'rates.coin_id', '=', 'user_notifications.coin_id')
                             ->join('users', 'user_notifications.user_id', '=', 'users.id')
                             ->select('users.id', 'users.name', 'users.email')
                             ->where('rates.source', '=', $provider->name)
                             ->whereBetween('rates.created_at', [$lastUpdate, $currentDate])
                             ->groupBy('users.id', 'users.name', 'users.email')
                             ->get();

        Log::debug(sprintf("[%s] Users needing notification: %s", $provider->name, $usersTonotify));

        if (count($usersTonotify) == 0) {
            Log::info(sprintf("[%s] No updates to send since last run", $provider->name));
            return;
        }

        $this->emailHelper->sendMail($usersTonotify);
    }
}
