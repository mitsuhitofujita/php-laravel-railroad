<?php

namespace Database\Seeders;

use App\Models\RailwayProvider;
use App\Models\RailwayProviderDetail;
use App\Models\RailwayProviderEventStream;
use App\Models\RailwayProviderHistory;
use App\Models\RailwayProviderHistoryDetail;
use App\Models\StoreRailwayProviderRequest;
use App\Models\UpdateRailwayProviderRequest;
use App\Models\RailwayRoute;
use App\Models\RailwayRouteDetail;
use App\Models\RailwayRouteHistory;
use App\Models\RailwayRouteHistoryDetail;
use App\Models\RailwayRouteStoreRequest;
use App\Models\RailwayRouteUpdateRequest;
use App\Models\RailwayRouteEventStream;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TruncateSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UpdateRailwayProviderRequest::truncate();
        StoreRailwayProviderRequest::truncate();
        RailwayProviderHistoryDetail::truncate();
        RailwayProviderHistory::truncate();
        RailwayProviderDetail::truncate();
        RailwayProvider::truncate();
        RailwayProviderEventStream::truncate();

        RailwayRouteUpdateRequest::truncate();
        RailwayRouteStoreRequest::truncate();
        RailwayRouteHistoryDetail::truncate();
        RailwayRouteHistory::truncate();
        RailwayRouteDetail::truncate();
        RailwayRoute::truncate();
        RailwayRouteEventStream::truncate();
    }
}
