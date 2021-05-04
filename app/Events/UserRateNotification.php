<?php

namespace App\Events;

use App\Models\ProviderMetadata;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserRateNotification
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The provider
     *
     * @var ProviderMetadata
     */
    public $provider;

    /**
     * The userData
     *
     * @var Object
     */
    public $userData;

    /**
     * The start date for the query to find coins
     *
     * @var string
     */
    public $startDate;

    /**
     * The end date for the query to find coins
     *
     * @var string
     */
    public $endDate;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ProviderMetadata $provider, object $userData, string $startDate, string $endDate)
    {
        $this->provider = $provider;
        $this->userData = $userData;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }
}
