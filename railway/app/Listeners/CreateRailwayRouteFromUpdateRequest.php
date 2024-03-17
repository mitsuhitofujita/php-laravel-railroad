<?php

namespace App\Listeners;

use App\Events\UpdateRailwayRouteRequestCreated;
use App\Models\RailwayRoute;
use App\Models\RailwayRouteDetail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CreateRailwayRouteFromUpdateRequest implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UpdateRailwayRouteRequestCreated $event): void
    {
        Log::debug('UpdateCreateRailwayRoute');
        Log::debug($event->updateRailwayRouteRequest['railway_route_id']);
        Log::debug($event->updateRailwayRouteRequest['railway_provider_id']);
        Log::debug($event->updateRailwayRouteRequest['name']);

        (new RailwayRouteDetail())->fill([
            'railway_route_id' => $event->updateRailwayRouteRequest['railway_route_id'],
            'railway_provider_id' => $event->updateRailwayRouteRequest['railway_provider_id'],
            'name' => $event->updateRailwayRouteRequest['name'],
        ])->save();
    }
}
