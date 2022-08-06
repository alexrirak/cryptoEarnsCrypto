<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserAlert;
use Illuminate\Support\Facades\Log;

class UnsubscribeController extends Controller
{
    public function showUnsubscribePage($emailId)
    {

        $email = hex2bin($emailId);

        $user = User::whereEmail($email)->first();

        if ($user) {
            $userAlerts = UserAlert::whereRaw("user_id in (select id from users where email = ?)", [$email])
                                   ->get();
        }

        if (!isset($userAlerts)) {
            Log::error(sprintf("[Unsubscribe] Unsubscribe lookup failed with invalid user for: %s, [%s]", $email, $emailId));
        }

        return view('unsubscribe', ["email" => $email, "emailId" => $emailId, "userAlertsCount" => isset($userAlerts) ? $userAlerts->count() : null]);

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
