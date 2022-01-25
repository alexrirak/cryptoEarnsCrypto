<?php

namespace App\Http\Controllers;

use App\Models\UserAlert;
use Illuminate\Support\Facades\Log;

class UnsubscribeController extends Controller
{
    public function showUnsubscribePage($emailId)
    {

        $email = hex2bin($emailId);

        $userAlerts = UserAlert::whereRaw("user_id in (select id from users where email = ?)", [$email])
                               ->get();

        if ($userAlerts->count() == 0) {
            Log::error(sprintf("[Unsubscribe] Unsubscribe lookup failed for: %s, [%s]", $email, $emailId));
        }

        return view('unsubscribe', ["email" => $email, "emailId" => $emailId, "userAlertsCount" => $userAlerts->count()]);

    }

    public function processUnsubscribe($emailId)
    {

        $email = hex2bin($emailId);

        $userAlerts = UserAlert::whereRaw("user_id in (select id from users where email = ?)", [$email])
                               ->delete();

        if ($userAlerts == 0) {
            Log::critical(sprintf("[Unsubscribe] Unsubscribe processing failed for: %s, [%s]", $email, $emailId));
            abort(400);
        }

        return response("", 204);

    }
}
