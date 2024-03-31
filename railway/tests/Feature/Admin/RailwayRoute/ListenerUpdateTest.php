<?php

namespace Tests\Feature\Admin\RailwayRoute;

use App\Events\RailwayRouteStoreRequestCreated;
use App\Events\RailwayRouteUpdateRequestCreated;
use App\Http\Controllers\Helpers\FormToken;

use App\Listeners\CreateRailwayRouteFromRequest;
use App\Listeners\UpdateRailwayRouteFromRequest;
use App\Models\RailwayProvider;
use App\Models\RailwayProviderEventStream;
use App\Models\RailwayRoute;
use App\Models\RailwayRouteDetail;
use App\Models\RailwayRouteEventStream;
use App\Models\RailwayRouteHistory;
use App\Models\RailwayRouteHistoryDetail;
use App\Models\RailwayRouteStoreRequest;
use App\Models\RailwayRouteUpdateRequest;
use Database\Seeders\Test\Admin\RailwayRoute\FixedSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class ListenerUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_detail_to_history_from_update_request(): void
    {
        $providerEventStream = RailwayProviderEventStream::factory()->create();

        $provider = RailwayProvider::factory()->state([
            'railway_provider_event_stream_id' => $providerEventStream['id'],
        ])->create();

        $eventStream = RailwayRouteEventStream::factory()->create();

        $route = RailwayRoute::factory()->state([
            'railway_route_event_stream_id' => $eventStream['id'],
        ])->create();

        $routeDetail = RailwayRouteDetail::factory()->state([
            'valid_from' => Carbon::parse('2024-01-01 00:00:00.000000'),
            'railway_provider_id' => $provider['id'],
            'name' => '旧鉄道路線',
        ])->create();

        $routeHistory = RailwayRouteHistory::factory()->state([
            'railway_route_id' => $route['id'],
        ])->create();

        $routeHistoryDetail = RailwayRouteHistoryDetail::factory()->state([
            'railway_route_history_id' => $routeHistory['id'],
            'railway_route_detail_id' => $routeDetail['id'],
        ])->create();

        $request = RailwayRouteUpdateRequest::factory()->state([
            'railway_route_event_stream_id' => $eventStream['id'],
            'token' => FormToken::make(),
            'railway_route_id' => $route['id'],
            'valid_from' => Carbon::parse('2024-03-02 00:00:00.999999'),
            'railway_provider_id' => $provider['id'],
            'name' => '更新鉄道路線',
        ])->create();

        $event = new RailwayRouteUpdateRequestCreated($request);
        $listener = new UpdateRailwayRouteFromRequest();
        $listener->handle($event);

        $this->assertIsObject($listener->railwayRouteHistory);
        $this->assertIsObject($listener->railwayRouteDetail);
        $this->assertIsObject($listener->railwayRouteHistoryDetail);

        $this->assertDatabaseHas('railway_routes', [
            'railway_route_event_stream_id' => $eventStream['id'],
        ]);

        $this->assertDatabaseHas('railway_route_histories', [
            'railway_route_id' => $request['railway_route_id'],
        ]);

        $this->assertDatabaseHas('railway_route_details', [
            'valid_from' => '2024-03-02 00:00:00.999999',
            'railway_provider_id' => $request['railway_provider_id'],
            'name' => '更新鉄道路線',
        ]);

        $this->assertDatabaseHas('railway_route_history_details', [
            'railway_route_history_id' => $listener->railwayRouteHistory['id'],
            'railway_route_detail_id' => $listener->railwayRouteDetail['id'],
        ]);
    }
}
