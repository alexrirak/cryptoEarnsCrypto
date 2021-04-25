<?php

namespace App\Listeners;

use App\Events\RatesProcessed;
use App\Helpers\EmailHelper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
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
     * @param  RatesProcessed  $event
     * @return void
     */
    public function handle(RatesProcessed $event)
    {
        Log::info("Handling rate update from [" . $event->provider . "]");
        $this->emailHelper->sendMail("test");
    }
}
