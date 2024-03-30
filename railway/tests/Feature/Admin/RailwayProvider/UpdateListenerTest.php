<?php

namespace Tests\Feature\Admin\RailwayProvider;

use App\Events\StoreRailwayProviderRequestCreated;
use App\Events\UpdateRailwayProviderRequestCreated;
use App\Http\Controllers\Helpers\FormToken;

use App\Listeners\CreateRailwayProviderFromStoreRequest;
use App\Listeners\CreateRailwayProviderFromUpdateRequest;
use App\Models\RailwayProvider;
use App\Models\RailwayProviderDetail;
use App\Models\RailwayProviderEventStream;
use App\Models\RailwayProviderHistory;
use App\Models\RailwayProviderHistoryDetail;
use App\Models\StoreRailwayProviderRequest;
use App\Models\UpdateRailwayProviderRequest;
use Database\Seeders\Test\Admin\RailwayProvider\FixedSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class UpdateListenerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_detail_to_history_from_update_request(): void
    {
        $eventStream = RailwayProviderEventStream::factory()->create();

        $railwayProvider = RailwayProvider::factory()->state([
            'railway_provider_event_stream_id' => $eventStream['id'],
        ])->create();

        $railwayProviderDetail = RailwayProviderDetail::factory()->state([
            'valid_from' => Carbon::parse('2024-01-01 00:00:00.000000'),
            'name' => '旧鉄道会社',
        ])->create();

        $railwayProviderHistory = RailwayProviderHistory::factory()->state([
            'railway_provider_id' => $railwayProvider['id'],
        ])->create();

        $railwayProviderHistoryDetail = RailwayProviderHistoryDetail::factory()->state([
            'railway_provider_history_id' => $railwayProviderHistory['id'],
            'railway_provider_detail_id' => $railwayProviderDetail['id'],
        ])->create();

        $request = UpdateRailwayProviderRequest::factory()->state([
            'railway_provider_event_stream_id' => $eventStream['id'],
            'token' => FormToken::make(),
            'railway_provider_id' => $railwayProvider['id'],
            'valid_from' => Carbon::parse('2024-03-02 00:00:00.000000'),
            'name' => '更新鉄道会社',
        ])->create();

        $event = new UpdateRailwayProviderRequestCreated($request);
        $listener = new CreateRailwayProviderFromUpdateRequest();
        $listener->handle($event);

        $this->assertIsObject($listener->railwayProviderHistory);
        $this->assertIsObject($listener->railwayProviderDetail);
        $this->assertIsObject($listener->railwayProviderHistoryDetail);

        $this->assertDatabaseHas('railway_providers', [
            'railway_provider_event_stream_id' => $eventStream['id'],
        ]);

        $this->assertDatabaseHas('railway_provider_histories', [
            'railway_provider_id' => $request['railway_provider_id'],
        ]);

        $this->assertDatabaseHas('railway_provider_details', [
            'valid_from' => '2024-03-02 00:00:00.000000',
            'name' => '更新鉄道会社',
        ]);

        $this->assertDatabaseHas('railway_provider_history_details', [
            'railway_provider_history_id' => $listener->railwayProviderHistory['id'],
            'railway_provider_detail_id' => $listener->railwayProviderDetail['id'],
        ]);
    }
}
