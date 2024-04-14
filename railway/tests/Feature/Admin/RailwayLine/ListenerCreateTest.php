<?php

namespace Tests\Feature\Admin\RailwayLine;

use App\Events\RailwayLineStoreRequestCreated;
use App\Http\Controllers\Helpers\FormToken;
use App\Listeners\CreateRailwayLineFromRequest;
use App\Models\RailwayProvider;
use App\Models\RailwayProviderEventStream;
use App\Models\RailwayLineEventStream;
use App\Models\RailwayLineStoreRequest;
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

        $eventStream = RailwayLineEventStream::factory()->create();
        $request = RailwayLineStoreRequest::factory()->state([
            'railway_line_event_stream_id' => $eventStream['id'],
            'token' => FormToken::make(),
            'railway_provider_id' => $provider['id'],
            'valid_from' => Carbon::parse('2024-01-01 00:00:00.999999'),
            'name' => '鉄道路線',
        ])->create();

        $event = new RailwayLineStoreRequestCreated($request);
        $listener = new CreateRailwayLineFromRequest();
        $listener->handle($event);

        $this->assertIsObject($listener->railwayRoute);
        $this->assertIsObject($listener->railwayRouteHistory);
        $this->assertIsObject($listener->railwayRouteDetail);
        $this->assertIsObject($listener->railwayRouteHistoryDetail);

        $this->assertDatabaseHas('railway_lines', [
            'railway_line_event_stream_id' => $eventStream['id'],
        ]);

        $this->assertDatabaseHas('railway_line_histories', [
            'railway_line_id' => $listener->railwayRoute['id'],
        ]);

        $this->assertDatabaseHas('railway_line_details', [
            'valid_from' => '2024-01-01 00:00:00.999999',
            'railway_provider_id' => $provider['id'],
            'name' => '鉄道路線',
        ]);

        $this->assertDatabaseHas('railway_line_history_details', [
            'railway_line_history_id' => $listener->railwayRouteHistory['id'],
            'railway_line_detail_id' => $listener->railwayRouteDetail['id'],
        ]);
    }
}
