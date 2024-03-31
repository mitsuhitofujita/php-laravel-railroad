<?php

namespace App\Providers;

use App\Events\RailwayProviderCreated;
use App\Events\RailwayRouteCreated;
use App\Events\StoreRailwayProviderRequestCreated;
use App\Events\RailwayRouteStoreRequestCreated;
use App\Events\UpdateRailwayProviderRequestCreated;
use App\Events\RailwayRouteUpdateRequestCreated;
use App\Listeners\CreateRailwayProviderFromStoreRequest;
use App\Listeners\CreateRailwayRouteFromRequest;
use App\Listeners\CreateRailwayProviderFromUpdateRequest;
use App\Listeners\UpdateRailwayRouteFromRequest;
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
        StoreRailwayProviderRequestCreated::class => [
            CreateRailwayProviderFromStoreRequest::class,
        ],
        UpdateRailwayProviderRequestCreated::class => [
            CreateRailwayProviderFromUpdateRequest::class,
        ],
        RailwayRouteStoreRequestCreated::class => [
            CreateRailwayRouteFromRequest::class,
        ],
        RailwayRouteUpdateRequestCreated::class => [
            UpdateRailwayRouteFromRequest::class,
        ],
        RailwayProviderCreated::class => [],
        RailwayRouteCreated::class => [],
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
