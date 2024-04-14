<?php

namespace App\Listeners;

use App\Events\RailwayStationStoreRequestCreated;
use App\Models\RailwayStation;
use App\Models\RailwayStationDetail;
use App\Models\RailwayStationHistory;
use App\Models\RailwayStationHistoryDetail;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class CreateRailwayStationFromRequest implements ShouldQueue, ShouldHandleEventsAfterCommit
{
    use InteractsWithQueue;

    public RailwayStation $railwayStation;
    public RailwayStationDetail $railwayStationDetail;
    public RailwayStationHistory $railwayStationHistory;
    public RailwayStationHistoryDetail $railwayStationHistoryDetail;

    public function __construct()
    {
    }

    public function handle(RailwayStationStoreRequestCreated $event): void
    {
        DB::transaction(function () use ($event) {
            $railwayStation = (new RailwayStation())->fill([
                'railway_station_event_stream_id' => $event->getRailwayStationEventStreamId(),
            ]);
            $railwayStation->save();

            $railwayStationDetail = (new RailwayStationDetail())->fill([
                'valid_from' => $event->getValidFrom(),
                'railway_line_id' => $event->getRailwayLineId(),
                'name' => $event->getName(),
                'nickname' => $event->getNickname(),
            ]);
            $railwayStationDetail->save();

            $railwayStationHistory = (new RailwayStationHistory())->fill([
                'railway_station_id' => $railwayStation['id'],
            ]);
            $railwayStationHistory->save();

            $railwayStationHistoryDetail = (new RailwayStationHistoryDetail())->fill([
                'railway_station_history_id' => $railwayStationHistory['id'],
                'railway_station_detail_id' => $railwayStationDetail['id'],
            ]);
            $railwayStationHistoryDetail->save();

            $this->railwayStation = $railwayStation;
            $this->railwayStationDetail = $railwayStationDetail;
            $this->railwayStationHistory = $railwayStationHistory;
            $this->railwayStationHistoryDetail = $railwayStationHistoryDetail;
        });
    }
}
