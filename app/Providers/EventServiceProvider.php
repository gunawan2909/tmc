<?php

namespace App\Providers;

use App\Events\CategoryDeleteEvent;
use App\Events\ProductStoreEvent;
use App\Events\CategoryStoreEvent;
use App\Events\ProductUpdateEvent;
use App\Events\CategoryUpdateEvent;
use App\Events\ProductDeleteEvent;
use App\Listeners\CategoryDeleteListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Listeners\ProductStoreListener;
use App\Listeners\CategoryStoreListener;
use App\Listeners\ProductUpdateListener;
use App\Listeners\CategoryUpdateListener;
use App\Listeners\ProductDeleteListener;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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
        ProductStoreEvent::class => [
            ProductStoreListener::class,
        ],
        ProductUpdateEvent::class => [
            ProductUpdateListener::class
        ],
        ProductDeleteEvent::class => [
            ProductDeleteListener::class
        ],
        CategoryStoreEvent::class => [
            CategoryStoreListener::class,
        ],
        CategoryUpdateEvent::class => [
            CategoryUpdateListener::class
        ],
        CategoryDeleteEvent::class => [
            CategoryDeleteListener::class
        ]

    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
