<?php

namespace App\Providers;

use App\Events\DataApprovedEvent;
use App\Events\DataTransactionCompletedEvent;
use App\Listeners\CallbacksManagerListener;
use App\Listeners\DataManagerListener;
use App\Subscribers\SendEmailNotificationSubscriber;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

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
        DataApprovedEvent::class => [
            DataManagerListener::class,
            CallbacksManagerListener::class,
        ],
        DataTransactionCompletedEvent::class => [
            // Add listeners upon your need
        ]
    ];

    protected $subscribe = [
        SendEmailNotificationSubscriber::class,
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
