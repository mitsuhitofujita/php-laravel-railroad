<?php

namespace App\Listeners;

use App\Events\StoreRailwayProviderRequestCreated;
use App\Models\RailwayProvider;
use App\Models\RailwayProviderDetail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CreateRailwayProviderFromStoreRequest implements ShouldQueue
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
    public function handle(StoreRailwayProviderRequestCreated $event): void
    {
        Log::debug('StoreCreateRailwayProvider');
        Log::debug($event->storeRailwayProviderRequest->railway_provider_event_stream_id);
        Log::debug($event->storeRailwayProviderRequest['railway_provider_event_stream_id']);
        Log::debug($event->storeRailwayProviderRequest->name);
        Log::debug($event->storeRailwayProviderRequest['name']);

        DB::transaction(function () use ($event) {
            $railwayProvider = (new RailwayProvider())->fill([
                'railway_provider_event_stream_id' => $event->storeRailwayProviderRequest['railway_provider_event_stream_id']
            ]);
            Log::debug($railwayProvider);
            $railwayProvider->save();

            (new RailwayProviderDetail())->fill([
                'railway_provider_id' => $railwayProvider->id,
                'name' => $event->storeRailwayProviderRequest['name'],
            ])->save();
        });
    }
}
