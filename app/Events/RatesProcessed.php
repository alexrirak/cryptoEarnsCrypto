<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RatesProcessed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The name of the provider.
     *
     * @var string
     */
    public $provider;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $provider)
    {
        $this->provider = $provider;
    }
}
