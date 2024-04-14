<?php

namespace App\Listeners;

use App\Events\RailwayLineUpdateRequestCreated;
use App\Models\RailwayLine;
use App\Models\RailwayLineDetail;
use App\Models\RailwayLineHistory;
use App\Models\RailwayLineHistoryDetail;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UpdateRailwayLineFromRequest implements ShouldQueue, ShouldHandleEventsAfterCommit
{
    use InteractsWithQueue;

    public RailwayLineHistory $railwayRouteHistory;
    public RailwayLineDetail $railwayRouteDetail;
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
    public function handle(RailwayLineUpdateRequestCreated $event): void
    {
        DB::transaction(function () use ($event) {
            $railwayRouteHistory = RailwayLineHistory::where('railway_line_id', $event->getRailwayLineId())
                ->orderBy('id', 'desc')
                ->firstOrFail();

            $railwayRouteDetail = (new RailwayLineDetail())->fill([
                'valid_from' => $event->getValidFrom(),
                'railway_provider_id' => $event->getRailwayProviderId(),
                'name' => $event->getName(),
            ]);
            $railwayRouteDetail->save();

            $railwayRouteHistoryDetail = (new RailwayLineHistoryDetail())
                ->fill([
                    'railway_line_history_id' => $railwayRouteHistory['id'],
                    'railway_line_detail_id' => $railwayRouteDetail['id'],
                ]);
            $railwayRouteHistoryDetail->save();

            $this->railwayRouteHistory = $railwayRouteHistory;
            $this->railwayRouteDetail = $railwayRouteDetail;
            $this->railwayRouteHistoryDetail = $railwayRouteHistoryDetail;
        });
    }
}
