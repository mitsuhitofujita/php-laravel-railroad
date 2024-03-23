<?php

namespace Database\Seeders;

use App\Http\Controllers\Helpers\FormToken;
use App\Models\RailwayProvider;
use App\Models\RailwayProviderDetail;
use App\Models\RailwayProviderEventStream;
use App\Models\StoreRailwayProviderDetailRequest;
use App\Models\StoreRailwayProviderRequest;
use App\Models\UpdateRailwayProviderDetailRequest;
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
            'valid_from' => Carbon::parse('2024-01-01 00:00:00.000'),
            'valid_to' => null,
            'name' => '旧鉄道会社',
        ])->create();

        $railwayProvider = RailwayProvider::factory()->state([
            'railway_provider_event_stream_id' => $railwayProviderEventStream['id'],
        ])->create();

        $railwayProviderDetail = RailwayProviderDetail::factory()->state([
            'railway_provider_id' => $railwayProvider['id'],
            'valid_from' => Carbon::parse('2024-01-01 00:00:00.000'),
            'valid_to' => null,
            'name' => '旧鉄道会社',
        ])->create();

        StoreRailwayProviderDetailRequest::factory()->state([
            'railway_provider_event_stream_id' => $railwayProviderEventStream['id'],
            'token' => FormToken::make(),
            'railway_provider_id' => $railwayProvider['id'],
            'valid_from' => Carbon::parse('2024-02-01 00:00:00.000'),
            'valid_to' => null,
            'name' => '新鉄道会社',
        ])->create();

        $railwayProviderDetail = RailwayProviderDetail::factory()->state([
            'railway_provider_id' => $railwayProvider['id'],
            'valid_from' => Carbon::parse('2024-02-01 00:00:00.000'),
            'valid_to' => null,
            'name' => '新鉄道会社',
        ])->create();

        UpdateRailwayProviderDetailRequest::factory()->state([
            'railway_provider_event_stream_id' => $railwayProviderEventStream['id'],
            'token' => FormToken::make(),
            'railway_provider_detail_id' => $railwayProviderDetail['id'],
            'valid_from' => Carbon::parse('2024-03-01 00:00:00.000'),
            'valid_to' => Carbon::parse('2030-03-01 00:00:00.000'),
            'name' => '新鉄道会社',
        ])->create();

        $railwayProviderDetail
            ->fill([
                'valid_from' => Carbon::parse('2024-03-01 00:00:00.000'),
                'valid_to' => Carbon::parse('2030-03-01 00:00:00.000'),
                'name' => '新鉄道会社',
            ])
            ->save();
    }
}
