<?php

namespace Tests\Feature\Admin\RailwayLine;

use App\Events\RailwayLineStoreRequestCreated;
use App\Events\RailwayLineUpdateRequestCreated;
use App\Http\Controllers\Helpers\FormToken;

use App\Listeners\CreateRailwayLineFromRequest;
use App\Listeners\UpdateRailwayLineFromRequest;
use App\Models\RailwayProvider;
use App\Models\RailwayProviderEventStream;
use App\Models\RailwayLine;
use App\Models\RailwayLineDetail;
use App\Models\RailwayLineEventStream;
use App\Models\RailwayLineHistory;
use App\Models\RailwayLineHistoryDetail;
use App\Models\RailwayLineStoreRequest;
use App\Models\RailwayLineUpdateRequest;
use Database\Seeders\Test\Admin\RailwayLine\FixedSeeder;
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

        $eventStream = RailwayLineEventStream::factory()->create();

        $route = RailwayLine::factory()->state([
            'railway_line_event_stream_id' => $eventStream['id'],
        ])->create();

        $routeDetail = RailwayLineDetail::factory()->state([
            'valid_from' => Carbon::parse('2024-01-01 00:00:00.000000'),
            'railway_provider_id' => $provider['id'],
            'name' => '旧鉄道路線',
        ])->create();

        $routeHistory = RailwayLineHistory::factory()->state([
            'railway_line_id' => $route['id'],
        ])->create();

        $routeHistoryDetail = RailwayLineHistoryDetail::factory()->state([
            'railway_line_history_id' => $routeHistory['id'],
            'railway_line_detail_id' => $routeDetail['id'],
        ])->create();

        $request = RailwayLineUpdateRequest::factory()->state([
            'railway_line_event_stream_id' => $eventStream['id'],
            'token' => FormToken::make(),
            'railway_line_id' => $route['id'],
            'valid_from' => Carbon::parse('2024-03-02 00:00:00.999999'),
            'railway_provider_id' => $provider['id'],
            'name' => '更新鉄道路線',
        ])->create();

        $event = new RailwayLineUpdateRequestCreated($request);
        $listener = new UpdateRailwayLineFromRequest();
        $listener->handle($event);

        $this->assertIsObject($listener->railwayRouteHistory);
        $this->assertIsObject($listener->railwayRouteDetail);
        $this->assertIsObject($listener->railwayRouteHistoryDetail);

        $this->assertDatabaseHas('railway_lines', [
            'railway_line_event_stream_id' => $eventStream['id'],
        ]);

        $this->assertDatabaseHas('railway_line_histories', [
            'railway_line_id' => $request['railway_line_id'],
        ]);

        $this->assertDatabaseHas('railway_line_details', [
            'valid_from' => '2024-03-02 00:00:00.999999',
            'railway_provider_id' => $request['railway_provider_id'],
            'name' => '更新鉄道路線',
        ]);

        $this->assertDatabaseHas('railway_line_history_details', [
            'railway_line_history_id' => $listener->railwayRouteHistory['id'],
            'railway_line_detail_id' => $listener->railwayRouteDetail['id'],
        ]);
    }
}
