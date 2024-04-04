<?php

namespace Tests\Feature\Admin\RailwayStation;

use App\Events\RailwayStationStoreRequestCreated;
use App\Http\Controllers\Helpers\FormToken;
use App\Listeners\CreateRailwayStationFromRequest;
use App\Models\RailwayRoute;
use App\Models\RailwayRouteEventStream;
use App\Models\RailwayStationEventStream;
use App\Models\RailwayStationStoreRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ListenerCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_listener(): void
    {
        $routeEventStream = RailwayRouteEventStream::factory()->create();
        $route = RailwayRoute::factory()->state([
            'railway_route_event_stream_id' => $routeEventStream['id'],
        ])->create();

        $eventStream = RailwayStationEventStream::factory()->create();
        $request = RailwayStationStoreRequest::factory()->state([
            'railway_station_event_stream_id' => $eventStream['id'],
            'token' => FormToken::make(),
            'railway_route_id' => $route['id'],
            'valid_from' => Carbon::parse('2024-01-01 00:00:00.999999'),
            'name' => '鉄道駅',
            'nickname' => '鉄道愛称',
        ])->create();

        $event = new RailwayStationStoreRequestCreated($request);
        $listener = new CreateRailwayStationFromRequest();
        $listener->handle($event);

        $this->assertIsObject($listener->railwayStation);
        $this->assertIsObject($listener->railwayStationHistory);
        $this->assertIsObject($listener->railwayStationDetail);
        $this->assertIsObject($listener->railwayStationHistoryDetail);

        $this->assertDatabaseHas('railway_stations', [
            'railway_station_event_stream_id' => $eventStream['id'],
        ]);

        $this->assertDatabaseHas('railway_station_histories', [
            'railway_station_id' => $listener->railwayStation['id'],
        ]);

        $this->assertDatabaseHas('railway_station_details', [
            'valid_from' => '2024-01-01 00:00:00.999999',
            'railway_route_id' => $route['id'],
            'name' => '鉄道駅',
            'nickname' => '鉄道愛称',
        ]);

        $this->assertDatabaseHas('railway_station_history_details', [
            'railway_station_history_id' => $listener->railwayStationHistory['id'],
            'railway_station_detail_id' => $listener->railwayStationDetail['id'],
        ]);
    }
}
