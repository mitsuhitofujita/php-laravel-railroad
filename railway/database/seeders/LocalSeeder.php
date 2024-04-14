<?php

namespace Database\Seeders;

use App\Http\Controllers\Helpers\FormToken;
use App\Models\RailwayProvider;
use App\Models\RailwayProviderDetail;
use App\Models\RailwayProviderHistory;
use App\Models\RailwayProviderHistoryDetail;
use App\Models\RailwayProviderEventStream;
use App\Models\StoreRailwayProviderRequest;
use App\Models\UpdateRailwayProviderRequest;
use App\Models\RailwayLine;
use App\Models\RailwayLineDetail;
use App\Models\RailwayLineEventStream;
use App\Models\RailwayLineHistory;
use App\Models\RailwayLineHistoryDetail;
use App\Models\RailwayLineStoreRequest;
use App\Models\RailwayLineUpdateRequest;
use App\Models\RailwayStation;
use App\Models\RailwayStationDetail;
use App\Models\RailwayStationEventStream;
use App\Models\RailwayStationHistory;
use App\Models\RailwayStationHistoryDetail;
use App\Models\RailwayStationStoreRequest;
use App\Models\RailwayStationUpdateRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class LocalSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $railwayProvider = $this->createRailwayProviderSeed();
        $railwayRoute = $this->createRailwayLineSeed($railwayProvider);
        $railwayStation = $this->createRailwayStationSeed($railwayRoute);
    }

    private function createRailwayProviderSeed(): RailwayProvider
    {
        $railwayProviderEventStream = RailwayProviderEventStream::factory()->create();

        StoreRailwayProviderRequest::factory()->state([
            'railway_provider_event_stream_id' => $railwayProviderEventStream['id'],
            'token' => FormToken::make(),
            'valid_from' => Carbon::parse('2024-01-01 00:00:00.000000'),
            'name' => '旧鉄道会社',
        ])->create();

        $railwayProvider = RailwayProvider::factory()->state([
            'railway_provider_event_stream_id' => $railwayProviderEventStream['id'],
        ])->create();

        $storyRailwayProviderDetail = RailwayProviderDetail::factory()->state([
            'valid_from' => Carbon::parse('2024-01-01 00:00:00.000000'),
            'name' => '旧鉄道会社',
        ])->create();

        $railwayProviderHistory = RailwayProviderHistory::factory()->state([
            'railway_provider_id' => $railwayProvider['id'],
        ])->create();

        RailwayProviderHistoryDetail::factory()->state([
            'railway_provider_history_id' => $railwayProviderHistory['id'],
            'railway_provider_detail_id' => $storyRailwayProviderDetail['id'],
        ])->create();

        UpdateRailwayProviderRequest::factory()->state([
            'railway_provider_event_stream_id' => $railwayProviderEventStream['id'],
            'token' => FormToken::make(),
            'railway_provider_id' => $railwayProvider['id'],
            'valid_from' => Carbon::parse('2024-03-01 00:00:00.000000'),
            'name' => '新鉄道会社',
        ])->create();

        $updateRailwayProviderDetail = RailwayProviderDetail::factory()->state([
            'valid_from' => Carbon::parse('2024-03-01 00:00:00.000000'),
            'name' => '新鉄道会社',
        ])->create();

        RailwayProviderHistoryDetail::factory()->state([
            'railway_provider_history_id' => $railwayProviderHistory['id'],
            'railway_provider_detail_id' => $updateRailwayProviderDetail['id'],
        ])->create();

        return $railwayProvider;
    }

    private function createRailwayLineSeed(RailwayProvider $railwayProvider): RailwayLine
    {
        $railwayRouteEventStream = RailwayLineEventStream::factory()->create();

        RailwayLineStoreRequest::factory()->state([
            'railway_line_event_stream_id' => $railwayRouteEventStream['id'],
            'token' => FormToken::make(),
            'valid_from' => Carbon::parse('2024-01-01 00:00:00.000000'),
            'railway_provider_id' => $railwayProvider['id'],
            'name' => '旧路線',
        ])->create();

        $railwayRoute = RailwayLine::factory()->state([
            'railway_line_event_stream_id' => $railwayRouteEventStream['id'],
        ])->create();

        $oldRailwayLineDetail = RailwayLineDetail::factory()->state([
            'valid_from' => Carbon::parse('2024-01-01 00:00:00.000000'),
            'railway_provider_id' => $railwayProvider['id'],
            'name' => '旧路線',
        ])->create();

        $railwayRouteHistory = RailwayLineHistory::factory()->state([
            'railway_line_id' => $railwayRoute['id'],
        ])->create();

        RailwayLineHistoryDetail::factory()->state([
            'railway_line_history_id' => $railwayRouteHistory['id'],
            'railway_line_detail_id' => $oldRailwayLineDetail['id'],
        ])->create();

        RailwayLineUpdateRequest::factory()->state([
            'railway_line_event_stream_id' => $railwayRouteEventStream['id'],
            'token' => FormToken::make(),
            'railway_line_id' => $railwayRoute['id'],
            'valid_from' => Carbon::parse('2024-03-01 00:00:00.000000'),
            'railway_provider_id' => $railwayProvider['id'],
            'name' => '新路線',
        ])->create();

        $newRailwayLineDetail = RailwayLineDetail::factory()->state([
            'railway_provider_id' => $railwayProvider['id'],
            'valid_from' => Carbon::parse('2024-03-01 00:00:00.000000'),
            'name' => '新路線',
        ])->create();

        RailwayLineHistoryDetail::factory()->state([
            'railway_line_history_id' => $railwayRouteHistory['id'],
            'railway_line_detail_id' => $newRailwayLineDetail['id'],
        ])->create();

        return $railwayRoute;
    }

    private function createRailwayStationSeed(RailwayLine $railwayRoute): RailwayStation
    {
        $railwayStationEventStream = RailwayStationEventStream::factory()->create();

        RailwayStationStoreRequest::factory()->state([
            'railway_station_event_stream_id' => $railwayStationEventStream['id'],
            'token' => FormToken::make(),
            'valid_from' => Carbon::parse('2024-01-01 00:00:00.000000'),
            'railway_line_id' => $railwayRoute['id'],
            'name' => '旧駅',
            'nickname' => '旧駅愛称',
        ])->create();

        $railwayStation = RailwayStation::factory()->state([
            'railway_station_event_stream_id' => $railwayStationEventStream['id'],
        ])->create();

        $oldRailwayStationDetail = RailwayStationDetail::factory()->state([
            'valid_from' => Carbon::parse('2024-01-01 00:00:00.000000'),
            'railway_line_id' => $railwayRoute['id'],
            'name' => '旧駅',
            'nickname' => '旧駅愛称',
        ])->create();

        $railwayStationHistory = RailwayStationHistory::factory()->state([
            'railway_station_id' => $railwayStation['id'],
        ])->create();

        RailwayStationHistoryDetail::factory()->state([
            'railway_station_history_id' => $railwayStationHistory['id'],
            'railway_station_detail_id' => $oldRailwayStationDetail['id'],
        ])->create();

        RailwayStationUpdateRequest::factory()->state([
            'railway_station_event_stream_id' => $railwayStationEventStream['id'],
            'token' => FormToken::make(),
            'railway_station_id' => $railwayStation['id'],
            'valid_from' => Carbon::parse('2024-03-01 00:00:00.000000'),
            'railway_line_id' => $railwayRoute['id'],
            'name' => '新駅',
            'nickname' => '新駅愛称',
        ])->create();

        $newRailwayStationDetail = RailwayStationDetail::factory()->state([
            'valid_from' => Carbon::parse('2024-03-01 00:00:00.000000'),
            'railway_line_id' => $railwayRoute['id'],
            'name' => '新駅',
            'nickname' => '新駅愛称',
        ])->create();

        RailwayStationHistoryDetail::factory()->state([
            'railway_station_history_id' => $railwayStationHistory['id'],
            'railway_station_detail_id' => $newRailwayStationDetail['id'],
        ])->create();

        return $railwayStation;
    }

}
