<?php

namespace Tests\Feature\Admin\RailwayStation;

use App\Events\RailwayStationStoreRequestCreated;
use App\Events\RailwayStationUpdateRequestCreated;
use App\Http\Controllers\Helpers\FormToken;

use App\Listeners\CreateRailwayStationFromRequest;
use App\Listeners\UpdateRailwayStationFromRequest;
use App\Models\RailwayLine;
use App\Models\RailwayLineEventStream;
use App\Models\RailwayStation;
use App\Models\RailwayStationDetail;
use App\Models\RailwayStationEventStream;
use App\Models\RailwayStationHistory;
use App\Models\RailwayStationHistoryDetail;
use App\Models\RailwayStationStoreRequest;
use App\Models\RailwayStationUpdateRequest;
use Database\Seeders\Test\Admin\RailwayStation\FixedSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class ListenerUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_update_detail_to_history_from_update_request(): void
    {
        $routeEventStream = RailwayLineEventStream::factory()->create();

        $route = RailwayLine::factory()->state([
            'railway_line_event_stream_id' => $routeEventStream['id'],
        ])->create();

        $eventStream = RailwayStationEventStream::factory()->create();

        $station = RailwayStation::factory()->state([
            'railway_station_event_stream_id' => $eventStream['id'],
        ])->create();

        $stationDetail = RailwayStationDetail::factory()->state([
            'valid_from' => Carbon::parse('2024-01-01 00:00:00.000000'),
            'railway_line_id' => $route['id'],
            'name' => '旧鉄道駅',
        ])->create();

        $stationHistory = RailwayStationHistory::factory()->state([
            'railway_station_id' => $station['id'],
        ])->create();

        $stationHistoryDetail = RailwayStationHistoryDetail::factory()->state([
            'railway_station_history_id' => $stationHistory['id'],
            'railway_station_detail_id' => $stationDetail['id'],
        ])->create();

        $request = RailwayStationUpdateRequest::factory()->state([
            'railway_station_event_stream_id' => $eventStream['id'],
            'token' => FormToken::make(),
            'railway_station_id' => $station['id'],
            'valid_from' => Carbon::parse('2024-03-02 00:00:00.999999'),
            'railway_line_id' => $route['id'],
            'name' => '更新鉄道駅',
            'nickname' => '更新鉄道愛称',
        ])->create();

        $event = new RailwayStationUpdateRequestCreated($request);
        $listener = new UpdateRailwayStationFromRequest();
        $listener->handle($event);

        $this->assertIsObject($listener->railwayStationHistory);
        $this->assertIsObject($listener->railwayStationDetail);
        $this->assertIsObject($listener->railwayStationHistoryDetail);

        $this->assertDatabaseHas('railway_stations', [
            'railway_station_event_stream_id' => $eventStream['id'],
        ]);

        $this->assertDatabaseHas('railway_station_histories', [
            'railway_station_id' => $request['railway_station_id'],
        ]);

        $this->assertDatabaseHas('railway_station_details', [
            'valid_from' => '2024-03-02 00:00:00.999999',
            'railway_line_id' => $request['railway_line_id'],
            'name' => '更新鉄道駅',
            'nickname' => '更新鉄道愛称',
        ]);

        $this->assertDatabaseHas('railway_station_history_details', [
            'railway_station_history_id' => $listener->railwayStationHistory['id'],
            'railway_station_detail_id' => $listener->railwayStationDetail['id'],
        ]);
    }
}
