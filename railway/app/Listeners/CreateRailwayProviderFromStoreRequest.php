<?php

namespace App\Listeners;

use App\Events\RailwayProviderStoreRequestCreated;
use App\Models\RailwayProvider;
use App\Models\RailwayProviderDetail;
use App\Models\RailwayProviderHistory;
use App\Models\RailwayProviderHistoryDetail;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class CreateRailwayProviderFromStoreRequest implements ShouldQueue, ShouldHandleEventsAfterCommit
{
    use InteractsWithQueue;

    public RailwayProvider $railwayProvider;
    public RailwayProviderDetail $railwayProviderDetail;
    public RailwayProviderHistory $railwayProviderHistory;
    public RailwayProviderHistoryDetail $railwayProviderHistoryDetail;

    public function __construct()
    {
    }

    public function handle(RailwayProviderStoreRequestCreated $event): void
    {
        DB::transaction(function () use ($event) {
            $railwayProvider = (new RailwayProvider())
                ->fill([
                    'railway_provider_event_stream_id' => $event->storeRailwayProviderRequest['railway_provider_event_stream_id']
                ]);
            $railwayProvider->save();

            $railwayProviderDetail = (new RailwayProviderDetail())
                ->fill([
                    'valid_from' => $event->storeRailwayProviderRequest['valid_from'],
                    'name' => $event->storeRailwayProviderRequest['name'],
                ]);
            $railwayProviderDetail->save();

            $railwayProviderHistory = (new RailwayProviderHistory())
                ->fill([
                    'railway_provider_id' => $railwayProvider['id'],
                ]);
            $railwayProviderHistory->save();

            $railwayProviderHistoryDetail = (new RailwayProviderHistoryDetail())
                ->fill([
                    'railway_provider_history_id' => $railwayProviderHistory['id'],
                    'railway_provider_detail_id' => $railwayProviderDetail['id'],
                ]);
            $railwayProviderHistoryDetail->save();

            $this->railwayProvider = $railwayProvider;
            $this->railwayProviderDetail = $railwayProviderDetail;
            $this->railwayProviderHistory = $railwayProviderHistory;
            $this->railwayProviderHistoryDetail = $railwayProviderHistoryDetail;
        });
    }
}
