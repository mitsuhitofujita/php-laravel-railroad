<?php

namespace Tests\Feature\Admin\RailwayProvider;

use App\Events\RailwayLineUpdateRequestCreated;
use App\Models\RailwayProviderEventStream;
use App\Models\RailwayProvider;
use App\Models\RailwayLine;
use App\Models\RailwayLineDetail;
use App\Models\RailwayLineEventStream;
use App\Models\RailwayLineHistory;
use App\Models\RailwayLineHistoryDetail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class ControllerUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_html_response_where_edit_admin_railway_providers_path(): void
    {
        $railwayProviderEventStream = RailwayProviderEventStream::factory()
            ->create();

        $railwayProvider = RailwayProvider::factory()
            ->state([
                    'railway_provider_event_stream_id' => $railwayProviderEventStream['id'],
            ])
            ->create();

        $railwayRouteEventStream = RailwayLineEventStream::factory()
            ->create();

        $railwayRoute = RailwayLine::factory()
            ->state([
                    'railway_line_event_stream_id' => $railwayRouteEventStream['id'],
            ])
            ->create();

        $railwayRouteDetail = RailwayLineDetail::factory()
            ->state([
                'valid_from' => Carbon::parse('2024-01-01 00:00:00.000000'),
                'railway_provider_id' => $railwayProvider['id'],
                'name' => 'route',
            ])
            ->create();

        $railwayRouteHistory = RailwayLineHistory::factory()
            ->state([
                'railway_line_id' => $railwayRoute['id'],
            ])
            ->create();

        RailwayLineHistoryDetail::factory()
            ->state([
                'railway_line_history_id' => $railwayRouteHistory['id'],
                'railway_line_detail_id' => $railwayRouteDetail['id'],
            ])
            ->create();

        $response = $this->get("/admin/railway_lines/{$railwayRoute['id']}/edit");
        $response->assertStatus(200);
    }

    public function test_create_update_railway_provider_request_when_put(): void
    {
        $railwayProviderEventStream = RailwayProviderEventStream::factory()
            ->create();

        $railwayProvider = RailwayProvider::factory()->state([
                'railway_provider_event_stream_id' => $railwayProviderEventStream['id'],
        ])
        ->create();

        $railwayRouteEventStream = RailwayLineEventStream::factory()
            ->create();

        $railwayRoute = RailwayLine::factory()
            ->state([
                'railway_line_event_stream_id' => $railwayRouteEventStream['id'],
            ])
            ->create();

        $railwayRouteDetail = RailwayLineDetail::factory()
            ->state([
                'valid_from' => Carbon::parse('2024-01-01 00:00:00.000000'),
                'railway_provider_id' => $railwayProvider['id'],
                'name' => 'route',
            ])
            ->create();

        $railwayRouteHistory = RailwayLineHistory::factory()
            ->state([
                'railway_line_id' => $railwayRoute['id'],
            ])
            ->create();

        RailwayLineHistoryDetail::factory()
            ->state([
                'railway_line_history_id' => $railwayRouteHistory['id'],
                'railway_line_detail_id' => $railwayRouteDetail['id'],
            ])
            ->create();

        Event::fake();

        $response = $this->put("/admin/railway_lines/{$railwayRoute['id']}", [
            'token' => 'target token',
            'valid_from' => '2024-01-01 00:00:00.999999',
            'railway_provider_id' => $railwayProvider['id'],
            'name' => 'target name',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('railway_line_update_requests', [
            'token' => 'target token',
            'valid_from' => '2024-01-01 00:00:00.999999',
            'railway_provider_id' => $railwayProvider['id'],
            'name' => 'target name',
        ]);
        Event::assertDispatched(RailwayLineUpdateRequestCreated::class);
    }
}
