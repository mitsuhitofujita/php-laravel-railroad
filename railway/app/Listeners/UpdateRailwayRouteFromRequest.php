<?php

namespace App\Listeners;

use App\Events\RailwayRouteUpdateRequestCreated;
use App\Models\RailwayRoute;
use App\Models\RailwayRouteDetail;
use App\Models\RailwayRouteHistory;
use App\Models\RailwayRouteHistoryDetail;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UpdateRailwayRouteFromRequest implements ShouldQueue, ShouldHandleEventsAfterCommit
{
    use InteractsWithQueue;

    public RailwayRouteHistory $railwayRouteHistory;
    public RailwayRouteDetail $railwayRouteDetail;
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
    public function handle(RailwayRouteUpdateRequestCreated $event): void
    {
        DB::transaction(function () use ($event) {
            $railwayRouteHistory = RailwayRouteHistory::where('railway_route_id', $event->getRailwayRouteId())
                ->orderBy('id', 'desc')
                ->firstOrFail();

            $railwayRouteDetail = (new RailwayRouteDetail())->fill([
                'valid_from' => $event->getValidFrom(),
                'railway_provider_id' => $event->getRailwayProviderId(),
                'name' => $event->getName(),
            ]);
            $railwayRouteDetail->save();

            $railwayRouteHistoryDetail = (new RailwayRouteHistoryDetail())
                ->fill([
                    'railway_route_history_id' => $railwayRouteHistory['id'],
                    'railway_route_detail_id' => $railwayRouteDetail['id'],
                ]);
            $railwayRouteHistoryDetail->save();

            $this->railwayRouteHistory = $railwayRouteHistory;
            $this->railwayRouteDetail = $railwayRouteDetail;
            $this->railwayRouteHistoryDetail = $railwayRouteHistoryDetail;
        });
    }
}
