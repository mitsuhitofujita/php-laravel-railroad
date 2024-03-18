<?php

namespace App\Listeners;

use App\Events\UpdateRailwayProviderRequestCreated;
use App\Models\RailwayProvider;
use App\Models\RailwayProviderDetail;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CreateRailwayProviderFromUpdateRequest implements ShouldQueue, ShouldHandleEventsAfterCommit
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
    public function handle(UpdateRailwayProviderRequestCreated $event): void
    {
        Log::debug('UpdateCreateRailwayProvider');
        Log::debug($event->updateRailwayProviderRequest['railway_provider_id']);
        Log::debug($event->updateRailwayProviderRequest['name']);

        $detail = (new RailwayProviderDetail())->fill([
            'railway_provider_id' => $event->updateRailwayProviderRequest['railway_provider_id'],
            'name' => $event->updateRailwayProviderRequest['name'],
        ]);
        $detail->save();
    }
}
