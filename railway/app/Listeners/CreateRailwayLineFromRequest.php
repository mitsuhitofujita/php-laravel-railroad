<?php

namespace App\Listeners;

use App\Events\RailwayLineStoreRequestCreated;
use App\Models\RailwayLine;
use App\Models\RailwayLineDetail;
use App\Models\RailwayLineHistory;
use App\Models\RailwayLineHistoryDetail;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CreateRailwayLineFromRequest implements ShouldQueue, ShouldHandleEventsAfterCommit
{
    use InteractsWithQueue;

    public RailwayLine $railwayRoute;
    public RailwayLineDetail $railwayRouteDetail;
    public RailwayLineHistory $railwayRouteHistory;
    public RailwayLineHistoryDetail $railwayRouteHistoryDetail;

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
    public function handle(RailwayLineStoreRequestCreated $event): void
    {
        DB::transaction(function () use ($event) {
            $railwayRoute = (new RailwayLine())->fill([
                'railway_line_event_stream_id' => $event->getRailwayLineEventStreamId(),
            ]);
            $railwayRoute->save();

            $railwayRouteDetail = (new RailwayLineDetail())->fill([
                'valid_from' => $event->getValidFrom(),
                'railway_provider_id' => $event->getRailwayProviderId(),
                'name' => $event->getName(),
            ]);
            $railwayRouteDetail->save();

            $railwayRouteHistory = (new RailwayLineHistory())->fill([
                'railway_line_id' => $railwayRoute['id'],
            ]);
            $railwayRouteHistory->save();

            $railwayRouteHistoryDetail = (new RailwayLineHistoryDetail())->fill([
                'railway_line_history_id' => $railwayRouteHistory['id'],
                'railway_line_detail_id' => $railwayRouteDetail['id'],
            ]);
            $railwayRouteHistoryDetail->save();

            $this->railwayRoute = $railwayRoute;
            $this->railwayRouteDetail = $railwayRouteDetail;
            $this->railwayRouteHistory = $railwayRouteHistory;
            $this->railwayRouteHistoryDetail = $railwayRouteHistoryDetail;
        });
    }
}
