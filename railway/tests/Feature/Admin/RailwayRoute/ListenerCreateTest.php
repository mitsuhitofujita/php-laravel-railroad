<?php

namespace Tests\Feature\Admin\RailwayRoute;

use App\Events\RailwayRouteStoreRequestCreated;
use App\Http\Controllers\Helpers\FormToken;
use App\Listeners\CreateRailwayRouteFromRequest;
use App\Models\RailwayProvider;
use App\Models\RailwayProviderEventStream;
use App\Models\RailwayRouteEventStream;
use App\Models\RailwayRouteStoreRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ListenerCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_listener(): void
    {
        $providerEventStream = RailwayProviderEventStream::factory()->create();
        $provider = RailwayProvider::factory()->state([
            'railway_provider_event_stream_id' => $providerEventStream['id'],
        ])->create();

        $eventStream = RailwayRouteEventStream::factory()->create();
        $request = RailwayRouteStoreRequest::factory()->state([
            'railway_route_event_stream_id' => $eventStream['id'],
            'token' => FormToken::make(),
            'railway_provider_id' => $provider['id'],
            'valid_from' => Carbon::parse('2024-01-01 00:00:00.999999'),
            'name' => '鉄道路線',
        ])->create();

        $event = new RailwayRouteStoreRequestCreated($request);
        $listener = new CreateRailwayRouteFromRequest();
        $listener->handle($event);

        $this->assertIsObject($listener->railwayRoute);
        $this->assertIsObject($listener->railwayRouteHistory);
        $this->assertIsObject($listener->railwayRouteDetail);
        $this->assertIsObject($listener->railwayRouteHistoryDetail);

        $this->assertDatabaseHas('railway_routes', [
            'railway_route_event_stream_id' => $eventStream['id'],
        ]);

        $this->assertDatabaseHas('railway_route_histories', [
            'railway_route_id' => $listener->railwayRoute['id'],
        ]);

        $this->assertDatabaseHas('railway_route_details', [
            'valid_from' => '2024-01-01 00:00:00.999999',
            'railway_provider_id' => $provider['id'],
            'name' => '鉄道路線',
        ]);

        $this->assertDatabaseHas('railway_route_history_details', [
            'railway_route_history_id' => $listener->railwayRouteHistory['id'],
            'railway_route_detail_id' => $listener->railwayRouteDetail['id'],
        ]);
    }
}
