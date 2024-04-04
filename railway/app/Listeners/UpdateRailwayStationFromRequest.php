<?php

namespace App\Listeners;

use App\Events\RailwayStationUpdateRequestCreated;
use App\Models\RailwayStationDetail;
use App\Models\RailwayStationHistory;
use App\Models\RailwayStationHistoryDetail;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class UpdateRailwayStationFromRequest implements ShouldQueue, ShouldHandleEventsAfterCommit
{
    use InteractsWithQueue;

    public RailwayStationHistory $railwayStationHistory;
    public RailwayStationDetail $railwayStationDetail;
    public RailwayStationHistoryDetail $railwayStationHistoryDetail;

    public function __construct()
    {
    }

    public function handle(RailwayStationUpdateRequestCreated $event): void
    {
        DB::transaction(function () use ($event) {
            $railwayStationHistory = RailwayStationHistory::where('railway_station_id', $event->getRailwayStationId())
                ->orderBy('id', 'desc')
                ->firstOrFail();

            $railwayStationDetail = (new RailwayStationDetail())->fill([
                'valid_from' => $event->getValidFrom(),
                'railway_route_id' => $event->getRailwayRouteId(),
                'name' => $event->getName(),
                'nickname' => $event->getNickname(),
            ]);
            $railwayStationDetail->save();

            $railwayStationHistoryDetail = (new RailwayStationHistoryDetail())
                ->fill([
                    'railway_station_history_id' => $railwayStationHistory['id'],
                    'railway_station_detail_id' => $railwayStationDetail['id'],
                ]);
            $railwayStationHistoryDetail->save();

            $this->railwayStationHistory = $railwayStationHistory;
            $this->railwayStationDetail = $railwayStationDetail;
            $this->railwayStationHistoryDetail = $railwayStationHistoryDetail;
        });
    }
}
