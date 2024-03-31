<?php

namespace App\Listeners;

use App\Events\RailwayRouteStoreRequestCreated;
use App\Models\RailwayRoute;
use App\Models\RailwayRouteDetail;
use App\Models\RailwayRouteHistory;
use App\Models\RailwayRouteHistoryDetail;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CreateRailwayRouteFromRequest implements ShouldQueue, ShouldHandleEventsAfterCommit
{
    use InteractsWithQueue;

    public RailwayRoute $railwayRoute;
    public RailwayRouteDetail $railwayRouteDetail;
    public RailwayRouteHistory $railwayRouteHistory;
    public RailwayRouteHistoryDetail $railwayRouteHistoryDetail;

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
    public function handle(RailwayRouteStoreRequestCreated $event): void
    {
        DB::transaction(function () use ($event) {
            $railwayRoute = (new RailwayRoute())->fill([
                'railway_route_event_stream_id' => $event->getRailwayRouteEventStreamId(),
            ]);
            $railwayRoute->save();

            $railwayRouteDetail = (new RailwayRouteDetail())->fill([
                'valid_from' => $event->getValidFrom(),
                'railway_provider_id' => $event->getRailwayProviderId(),
                'name' => $event->getName(),
            ]);
            $railwayRouteDetail->save();

            $railwayRouteHistory = (new RailwayRouteHistory())->fill([
                'railway_route_id' => $railwayRoute['id'],
            ]);
            $railwayRouteHistory->save();

            $railwayRouteHistoryDetail = (new RailwayRouteHistoryDetail())->fill([
                'railway_route_history_id' => $railwayRouteHistory['id'],
                'railway_route_detail_id' => $railwayRouteDetail['id'],
            ]);
            $railwayRouteHistoryDetail->save();

            $this->railwayRoute = $railwayRoute;
            $this->railwayRouteDetail = $railwayRouteDetail;
            $this->railwayRouteHistory = $railwayRouteHistory;
            $this->railwayRouteHistoryDetail = $railwayRouteHistoryDetail;
        });
    }
}
