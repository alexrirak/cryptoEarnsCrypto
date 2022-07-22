<?php

namespace App\Providers;

use App\Events\DeleteUser;
use App\Events\RatesProcessed;
use App\Events\UserRateNotification;
use App\Listeners\DeleteUserListener;
use App\Listeners\RatesProcessedListener;
use App\Listeners\UserRateNotificationSender;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        RatesProcessed::class => [
            RatesProcessedListener::class,
        ],
        UserRateNotification::class => [
            UserRateNotificationSender::class
        ],
        DeleteUser::class => [
            DeleteUserListener::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
