<?php

namespace Tests\Feature\Admin\RailwayProvider;

use App\Events\RailwayRouteUpdateRequestCreated;
use App\Models\RailwayProviderEventStream;
use App\Models\RailwayProvider;
use App\Models\RailwayRoute;
use App\Models\RailwayRouteDetail;
use App\Models\RailwayRouteEventStream;
use App\Models\RailwayRouteHistory;
use App\Models\RailwayRouteHistoryDetail;
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

        $railwayRouteEventStream = RailwayRouteEventStream::factory()
            ->create();

        $railwayRoute = RailwayRoute::factory()
            ->state([
                    'railway_route_event_stream_id' => $railwayRouteEventStream['id'],
            ])
            ->create();

        $railwayRouteDetail = RailwayRouteDetail::factory()
            ->state([
                'valid_from' => Carbon::parse('2024-01-01 00:00:00.000000'),
                'railway_provider_id' => $railwayProvider['id'],
                'name' => 'route',
            ])
            ->create();

        $railwayRouteHistory = RailwayRouteHistory::factory()
            ->state([
                'railway_route_id' => $railwayRoute['id'],
            ])
            ->create();

        RailwayRouteHistoryDetail::factory()
            ->state([
                'railway_route_history_id' => $railwayRouteHistory['id'],
                'railway_route_detail_id' => $railwayRouteDetail['id'],
            ])
            ->create();

        $response = $this->get("/admin/railway_routes/{$railwayRoute['id']}/edit");
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

        $railwayRouteEventStream = RailwayRouteEventStream::factory()
            ->create();

        $railwayRoute = RailwayRoute::factory()
            ->state([
                'railway_route_event_stream_id' => $railwayRouteEventStream['id'],
            ])
            ->create();

        $railwayRouteDetail = RailwayRouteDetail::factory()
            ->state([
                'valid_from' => Carbon::parse('2024-01-01 00:00:00.000000'),
                'railway_provider_id' => $railwayProvider['id'],
                'name' => 'route',
            ])
            ->create();

        $railwayRouteHistory = RailwayRouteHistory::factory()
            ->state([
                'railway_route_id' => $railwayRoute['id'],
            ])
            ->create();

        RailwayRouteHistoryDetail::factory()
            ->state([
                'railway_route_history_id' => $railwayRouteHistory['id'],
                'railway_route_detail_id' => $railwayRouteDetail['id'],
            ])
            ->create();

        Event::fake();

        $response = $this->put("/admin/railway_routes/{$railwayRoute['id']}", [
            'token' => 'target token',
            'valid_from' => '2024-01-01 00:00:00.999999',
            'railway_provider_id' => $railwayProvider['id'],
            'name' => 'target name',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('railway_route_update_requests', [
            'token' => 'target token',
            'valid_from' => '2024-01-01 00:00:00.999999',
            'railway_provider_id' => $railwayProvider['id'],
            'name' => 'target name',
        ]);
        Event::assertDispatched(RailwayRouteUpdateRequestCreated::class);
    }
}
