<?php

namespace Database\Seeders;

use App\Models\RailwayProvider;
use App\Models\RailwayProviderDetail;
use App\Models\RailwayProviderEventStream;
use App\Models\RailwayProviderHistory;
use App\Models\RailwayProviderHistoryDetail;
use App\Models\StoreRailwayProviderRequest;
use App\Models\UpdateRailwayProviderRequest;
use App\Models\RailwayLine;
use App\Models\RailwayLineDetail;
use App\Models\RailwayLineHistory;
use App\Models\RailwayLineHistoryDetail;
use App\Models\RailwayLineStoreRequest;
use App\Models\RailwayLineUpdateRequest;
use App\Models\RailwayLineEventStream;
use App\Models\RailwayStation;
use App\Models\RailwayStationDetail;
use App\Models\RailwayStationHistory;
use App\Models\RailwayStationHistoryDetail;
use App\Models\RailwayStationStoreRequest;
use App\Models\RailwayStationUpdateRequest;
use App\Models\RailwayStationEventStream;
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

        RailwayLineUpdateRequest::truncate();
        RailwayLineStoreRequest::truncate();
        RailwayLineHistoryDetail::truncate();
        RailwayLineHistory::truncate();
        RailwayLineDetail::truncate();
        RailwayLine::truncate();
        RailwayLineEventStream::truncate();

        RailwayStationUpdateRequest::truncate();
        RailwayStationStoreRequest::truncate();
        RailwayStationHistoryDetail::truncate();
        RailwayStationHistory::truncate();
        RailwayStationDetail::truncate();
        RailwayStation::truncate();
        RailwayStationEventStream::truncate();
    }
}
