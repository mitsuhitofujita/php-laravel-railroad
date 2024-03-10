<?php

namespace App\Listeners;

use App\Events\StoreRailwayProviderRequestCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

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
        Log::debug($event->railwayProviderRequest->name);
    }
}
