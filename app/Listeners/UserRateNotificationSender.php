<?php

namespace App\Listeners;

use App\Events\UserRateNotification;
use App\Helpers\EmailHelper;
use Illuminate\Support\Facades\Log;

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
     * @param  UserRateNotification  $event
     * @return void
     */
    public function handle(UserRateNotification $event)
    {
        Log::info(sprintf("[%s][User Rate Notification] Handling user rate notification for: %s", $event->provider->name, $event->userData));
    }
}
