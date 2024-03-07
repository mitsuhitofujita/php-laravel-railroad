<?php

namespace App\Listeners;

use App\Events\RailwayProviderRequestCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class CreateRailwayProvider implements ShouldQueue
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
    public function handle(RailwayProviderRequestCreated $event): void
    {
        Log::debug('CreateRailwayProvider');
        Log::debug($event->railwayProviderRequest->name);
    }
}
