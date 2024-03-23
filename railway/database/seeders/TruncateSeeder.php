<?php

namespace Database\Seeders;

use App\Models\RailwayProvider;
use App\Models\RailwayProviderDetail;
use App\Models\RailwayProviderEventStream;
use App\Models\StoreRailwayProviderDetailRequest;
use App\Models\StoreRailwayProviderRequest;
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
        StoreRailwayProviderDetailRequest::truncate();
        StoreRailwayProviderRequest::truncate();
        RailwayProviderDetail::truncate();
        RailwayProvider::truncate();
        RailwayProviderEventStream::truncate();
    }
}
