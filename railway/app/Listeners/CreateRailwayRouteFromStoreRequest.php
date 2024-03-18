<?php

namespace App\Listeners;

use App\Events\StoreRailwayRouteRequestCreated;
use App\Models\RailwayRoute;
use App\Models\RailwayRouteDetail;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CreateRailwayRouteFromStoreRequest implements ShouldQueue, ShouldHandleEventsAfterCommit
{
    use InteractsWithQueue;

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
    public function handle(StoreRailwayRouteRequestCreated $event): void
    {
        Log::debug('StoreCreateRailwayRoute');
        Log::debug($event->storeRailwayRouteRequest['railway_route_event_stream_id']);
        Log::debug($event->storeRailwayRouteRequest['railway_provider_id']);
        Log::debug($event->storeRailwayRouteRequest['name']);

        DB::transaction(function () use ($event) {
            $railwayRoute = (new RailwayRoute())->fill([
                'railway_route_event_stream_id' => $event->storeRailwayRouteRequest['railway_route_event_stream_id']
            ]);
            $railwayRoute->save();

            (new RailwayRouteDetail())->fill([
                'railway_route_id' => $railwayRoute['id'],
                'railway_provider_id' => $event->storeRailwayRouteRequest['railway_provider_id'],
                'name' => $event->storeRailwayRouteRequest['name'],
            ])->save();
        });
    }
}
