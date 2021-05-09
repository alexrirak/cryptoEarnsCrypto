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

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
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
        ]
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
}
