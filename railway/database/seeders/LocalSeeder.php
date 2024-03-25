<?php

namespace Database\Seeders;

use App\Http\Controllers\Helpers\FormToken;
use App\Models\RailwayProvider;
use App\Models\RailwayProviderDetail;
use App\Models\RailwayProviderEventStream;
use App\Models\StoreRailwayProviderRequest;
use App\Models\UpdateRailwayProviderRequest;
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

        RailwayProviderDetail::factory()->state([
            'railway_provider_id' => $railwayProvider['id'],
            'valid_from' => Carbon::parse('2024-01-01 00:00:00.000000'),
            'name' => '旧鉄道会社',
        ])->create();

        UpdateRailwayProviderRequest::factory()->state([
            'railway_provider_event_stream_id' => $railwayProviderEventStream['id'],
            'token' => FormToken::make(),
            'railway_provider_id' => $railwayProvider['id'],
            'valid_from' => Carbon::parse('2024-03-01 00:00:00.000000'),
            'name' => '新鉄道会社',
        ])->create();

        RailwayProviderDetail::factory()->state([
            'railway_provider_id' => $railwayProvider['id'],
            'valid_from' => Carbon::parse('2024-03-01 00:00:00.000000'),
            'name' => '新鉄道会社',
        ])->create();
    }
}
