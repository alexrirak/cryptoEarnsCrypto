<?php

namespace App\Listeners;

use App\Events\UserRateNotification;
use App\Helpers\EmailHelper;
use App\Mail\RateChange;
use App\Models\Rate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UserRateNotificationSender
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
     * @param UserRateNotification $event
     * @return void
     */
    public function handle(UserRateNotification $event)
    {
        Log::info(sprintf("[%s][User Rate Notification] Handling user rate notification for: %s", $event->provider->name, $event->userData));

        $updatedRates = Rate::join('coin_metadata', 'rates.coin_id', '=', 'coin_metadata.id')
                            ->join('user_alerts', 'rates.coin_id', '=', 'user_alerts.coin_id')
                            ->join('users', 'user_alerts.user_id', '=', 'users.id')
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
                                DB::raw('(count(rates.created_at) > 2) as chartAvailable'),
                                'rates.source',
                                'user_alerts.use_special'
                            )
                            ->where('rates.source', '=', $event->provider->name)
                            ->where('users.id', '=', $event->userData->id)
                            ->whereBetween('rates.created_at', [$event->startDate, $event->endDate])
                            ->groupBy('rates.coin_id', 'rates.source', 'user_alerts.use_special')
                            ->get();

        Log::debug(sprintf("[%s][User Rate Notification] Coins fetched: %s", $event->provider->name, $updatedRates), ["user" => $event->userData]);

        Mail::to($event->userData->email)
            ->send(new RateChange($updatedRates, $event->userData, $event->provider));

        Log::info(sprintf("[%s][User Rate Notification] Sent user rate notification for: %s", $event->provider->name, $event->userData));

    }
}
