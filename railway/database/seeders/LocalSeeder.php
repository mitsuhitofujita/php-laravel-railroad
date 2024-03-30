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
            'railway_provider_id' => $railwayProvider['id'],
            'valid_from' => Carbon::parse('2024-01-01 00:00:00.000000'),
            'name' => '旧路線',
        ])->create();

        $railwayRoute = RailwayRoute::factory()->state([
            'railway_route_event_stream_id' => $railwayRouteEventStream['id'],
        ])->create();

        $oldRailwayRouteDetail = RailwayRouteDetail::factory()->state([
            'railway_provider_id' => $railwayProvider['id'],
            'valid_from' => Carbon::parse('2024-01-01 00:00:00.000000'),
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
            'railway_provider_id' => $railwayProvider['id'],
            'valid_from' => Carbon::parse('2024-03-01 00:00:00.000000'),
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
}
