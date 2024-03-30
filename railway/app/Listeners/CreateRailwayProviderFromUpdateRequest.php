<?php

namespace App\Listeners;

use App\Events\UpdateRailwayProviderRequestCreated;
use App\Models\RailwayProvider;
use App\Models\RailwayProviderDetail;
use App\Models\RailwayProviderHistory;
use App\Models\RailwayProviderHistoryDetail;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CreateRailwayProviderFromUpdateRequest implements ShouldQueue, ShouldHandleEventsAfterCommit
{
    use InteractsWithQueue;

    public RailwayProviderHistory $railwayProviderHistory;
    public RailwayProviderDetail $railwayProviderDetail;
    public RailwayProviderHistoryDetail $railwayProviderHistoryDetail;

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
    public function handle(UpdateRailwayProviderRequestCreated $event): void
    {
        DB::transaction(function () use ($event) {
            $railwayProviderHistory = RailwayProviderHistory::where('railway_provider_id', $event->getRailwayProviderId())
                ->orderBy('id', 'desc')
                ->firstOrFail();

            $railwayProviderDetail = (new RailwayProviderDetail())->fill([
                'valid_from' => $event->updateRailwayProviderRequest['valid_from'],
                'name' => $event->updateRailwayProviderRequest['name'],
            ]);
            $railwayProviderDetail->save();

            $railwayProviderHistoryDetail = (new RailwayProviderHistoryDetail())
                ->fill([
                    'railway_provider_history_id' => $railwayProviderHistory['id'],
                    'railway_provider_detail_id' => $railwayProviderDetail['id'],
                ]);
            $railwayProviderHistoryDetail->save();

            $this->railwayProviderHistory = $railwayProviderHistory;
            $this->railwayProviderDetail = $railwayProviderDetail;
            $this->railwayProviderHistoryDetail = $railwayProviderHistoryDetail;
        });
    }
}
