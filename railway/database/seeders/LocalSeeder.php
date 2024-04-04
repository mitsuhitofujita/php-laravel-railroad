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
use App\Models\RailwayRoute;
use App\Models\RailwayRouteDetail;
use App\Models\RailwayRouteEventStream;
use App\Models\RailwayRouteHistory;
use App\Models\RailwayRouteHistoryDetail;
use App\Models\RailwayRouteStoreRequest;
use App\Models\RailwayRouteUpdateRequest;
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
        $railwayRoute = $this->createRailwayRouteSeed($railwayProvider);
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

    private function createRailwayRouteSeed(RailwayProvider $railwayProvider): RailwayRoute
    {
        $railwayRouteEventStream = RailwayRouteEventStream::factory()->create();

        RailwayRouteStoreRequest::factory()->state([
            'railway_route_event_stream_id' => $railwayRouteEventStream['id'],
            'token' => FormToken::make(),
            'valid_from' => Carbon::parse('2024-01-01 00:00:00.000000'),
            'railway_provider_id' => $railwayProvider['id'],
            'name' => '旧路線',
        ])->create();

        $railwayRoute = RailwayRoute::factory()->state([
            'railway_route_event_stream_id' => $railwayRouteEventStream['id'],
        ])->create();

        $oldRailwayRouteDetail = RailwayRouteDetail::factory()->state([
            'valid_from' => Carbon::parse('2024-01-01 00:00:00.000000'),
            'railway_provider_id' => $railwayProvider['id'],
            'name' => '旧路線',
        ])->create();

        $railwayRouteHistory = RailwayRouteHistory::factory()->state([
            'railway_route_id' => $railwayRoute['id'],
        ])->create();

        RailwayRouteHistoryDetail::factory()->state([
            'railway_route_history_id' => $railwayRouteHistory['id'],
            'railway_route_detail_id' => $oldRailwayRouteDetail['id'],
        ])->create();

        RailwayRouteUpdateRequest::factory()->state([
            'railway_route_event_stream_id' => $railwayRouteEventStream['id'],
            'token' => FormToken::make(),
            'railway_route_id' => $railwayRoute['id'],
            'valid_from' => Carbon::parse('2024-03-01 00:00:00.000000'),
            'railway_provider_id' => $railwayProvider['id'],
            'name' => '新路線',
        ])->create();

        $newRailwayRouteDetail = RailwayRouteDetail::factory()->state([
            'railway_provider_id' => $railwayProvider['id'],
            'valid_from' => Carbon::parse('2024-03-01 00:00:00.000000'),
            'name' => '新路線',
        ])->create();

        RailwayRouteHistoryDetail::factory()->state([
            'railway_route_history_id' => $railwayRouteHistory['id'],
            'railway_route_detail_id' => $newRailwayRouteDetail['id'],
        ])->create();

        return $railwayRoute;
    }

    private function createRailwayStationSeed(RailwayRoute $railwayRoute): RailwayStation
    {
        $railwayStationEventStream = RailwayStationEventStream::factory()->create();

        RailwayStationStoreRequest::factory()->state([
            'railway_station_event_stream_id' => $railwayStationEventStream['id'],
            'token' => FormToken::make(),
            'valid_from' => Carbon::parse('2024-01-01 00:00:00.000000'),
            'railway_route_id' => $railwayRoute['id'],
            'name' => '旧駅',
            'nickname' => '旧駅愛称',
        ])->create();

        $railwayStation = RailwayStation::factory()->state([
            'railway_station_event_stream_id' => $railwayStationEventStream['id'],
        ])->create();

        $oldRailwayStationDetail = RailwayStationDetail::factory()->state([
            'valid_from' => Carbon::parse('2024-01-01 00:00:00.000000'),
            'railway_route_id' => $railwayRoute['id'],
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
            'railway_route_id' => $railwayRoute['id'],
            'name' => '新駅',
            'nickname' => '新駅愛称',
        ])->create();

        $newRailwayStationDetail = RailwayStationDetail::factory()->state([
            'valid_from' => Carbon::parse('2024-03-01 00:00:00.000000'),
            'railway_route_id' => $railwayRoute['id'],
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
