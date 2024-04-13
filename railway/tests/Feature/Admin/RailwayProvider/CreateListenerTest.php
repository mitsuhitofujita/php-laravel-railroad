<?php

namespace Tests\Feature\Admin\RailwayProvider;

use App\Events\RailwayProviderStoreRequestCreated;
use App\Http\Controllers\Helpers\FormToken;
use App\Listeners\CreateRailwayProviderFromStoreRequest;
use App\Models\RailwayProvider;
use App\Models\RailwayProviderEventStream;
use App\Models\StoreRailwayProviderRequest;
use Database\Seeders\Test\Admin\RailwayProvider\FixedSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CreateListenerTest extends TestCase
{
    use RefreshDatabase;

    public function test_listener(): void
    {
        $eventStream = RailwayProviderEventStream::factory()->create();
        $request = StoreRailwayProviderRequest::factory()->state([
            'railway_provider_event_stream_id' => $eventStream['id'],
            'token' => FormToken::make(),
            'valid_from' => Carbon::parse('2024-01-01 00:00:00.000000'),
            'name' => '鉄道会社',
        ])->create();
        $event = new RailwayProviderStoreRequestCreated($request);
        $listener = new CreateRailwayProviderFromStoreRequest();
        $listener->handle($event);

        $this->assertIsObject($listener->railwayProvider);
        $this->assertIsObject($listener->railwayProviderHistory);
        $this->assertIsObject($listener->railwayProviderDetail);
        $this->assertIsObject($listener->railwayProviderHistoryDetail);

        $this->assertDatabaseHas('railway_providers', [
            'railway_provider_event_stream_id' => $eventStream['id'],
        ]);

        $this->assertDatabaseHas('railway_provider_histories', [
            'railway_provider_id' => $listener->railwayProvider['id'],
        ]);

        $this->assertDatabaseHas('railway_provider_details', [
            'valid_from' => '2024-01-01 00:00:00.000000',
            'name' => '鉄道会社',
        ]);

        $this->assertDatabaseHas('railway_provider_history_details', [
            'railway_provider_history_id' => $listener->railwayProviderHistory['id'],
            'railway_provider_detail_id' => $listener->railwayProviderDetail['id'],
        ]);
    }
}
