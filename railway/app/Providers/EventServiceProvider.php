<?php

namespace App\Providers;

use App\Events\RailwayProviderCreated;
use App\Events\RailwayLineCreated;
use App\Events\RailwayProviderStoreRequestCreated;
use App\Events\RailwayLineStoreRequestCreated;
use App\Events\RailwayProviderUpdateRequestCreated;
use App\Events\RailwayLineUpdateRequestCreated;
use App\Listeners\CreateRailwayProviderFromStoreRequest;
use App\Listeners\CreateRailwayLineFromRequest;
use App\Listeners\CreateRailwayProviderFromUpdateRequest;
use App\Listeners\UpdateRailwayLineFromRequest;
use Illuminate\Auth\Events\Registered;
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
        RailwayProviderStoreRequestCreated::class => [
            CreateRailwayProviderFromStoreRequest::class,
        ],
        RailwayProviderUpdateRequestCreated::class => [
            CreateRailwayProviderFromUpdateRequest::class,
        ],
        RailwayLineStoreRequestCreated::class => [
            CreateRailwayLineFromRequest::class,
        ],
        RailwayLineUpdateRequestCreated::class => [
            UpdateRailwayLineFromRequest::class,
        ],
        RailwayProviderCreated::class => [],
        RailwayLineCreated::class => [],
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
