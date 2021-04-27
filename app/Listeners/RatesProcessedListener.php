<?php

namespace App\Listeners;

use App\Events\RatesProcessed;
use App\Helpers\EmailHelper;
use App\Models\EmailLog;
use App\Models\ProviderMetadata;
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

        $provider = ProviderMetadata::where('name', $event->provider)->first();

        if (!$provider) {
            Log::critical(sprintf("Received 'RatesProcessed' event for unknown provider '%s'", $event->provider));
            return;
        }

        $emailLog = EmailLog::where('provider_id','=',$provider->id)
                            ->where('type','=','UPDATE')
                            ->orderBy('created_at')
                            ->first();

        $lastUpdate = $emailLog ? $emailLog->created_at : date("Y-m-d H:i:s");

        $this->emailHelper->sendMail($lastUpdate);
    }
}
