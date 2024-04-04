<?php

namespace Tests\Feature;

use App\Events\RailwayStationStoreRequestCreated;
use App\Http\Controllers\Helpers\FormToken;
use App\Models\RailwayProvider;
use App\Models\RailwayProviderEventStream;
use App\Models\RailwayRoute;
use App\Models\RailwayRouteDetail;
use App\Models\RailwayRouteEventStream;
use App\Models\RailwayStationEventStream;
use App\Models\RailwayStationStoreRequest;
use App\Models\StoreRailwayRouteRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class ControllerCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_html_response_where_create_admin_railway_stations_path(): void
    {
        $response = $this->get('/admin/railway_stations/create');
        $response->assertStatus(200);
    }

    public function test_create_store_railway_station_request_when_post(): void
    {
        Event::fake();

        $railwayRouteEventStream = RailwayRouteEventStream::factory()
            ->create();

        $railwayRoute = RailwayRoute::factory()->state([
            'railway_route_event_stream_id' => $railwayRouteEventStream['id'],
        ])->create();

        $response = $this->post('/admin/railway_stations', [
            'token' => 'target token',
            'valid_from' => '2024-01-01 00:00:00.999999',
            'railway_route_id' => $railwayRoute['id'],
            'name' => 'target station',
            'nickname' => 'target nickname',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('railway_station_store_requests', [
            'token' => 'target token',
            'valid_from' => '2024-01-01 00:00:00.999999',
            'railway_route_id' => $railwayRoute['id'],
            'name' => 'target station',
            'nickname' => 'target nickname',
        ]);
        Event::assertDispatched(RailwayStationStoreRequestCreated::class);
    }
}
