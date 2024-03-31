<?php

namespace Tests\Feature;

use App\Events\RailwayRouteStoreRequestCreated;
use App\Http\Controllers\Helpers\FormToken;
use App\Models\RailwayProvider;
use App\Models\RailwayProviderDetail;
use App\Models\RailwayProviderEventStream;
use App\Models\RailwayRouteEventStream;
use App\Models\RailwayRouteStoreRequest;
use App\Models\StoreRailwayProviderRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class ControllerCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_html_response_where_create_admin_railway_routes_path(): void
    {
        $response = $this->get('/admin/railway_routes/create');
        $response->assertStatus(200);
    }

    public function test_get_validation_error_too_long_railway_route_name_when_post(): void
    {
        $railwayProviderEventStream = RailwayProviderEventStream::factory()
            ->create();

        $railwayProvider = RailwayProvider::factory()->state([
            'railway_provider_event_stream_id' => $railwayProviderEventStream['id'],
        ])->create();

        $response = $this->post('/admin/railway_routes', [
            'token' => FormToken::make(),
            'valid_from' => '2024-01-01 00:00:00.000000',
            'railway_provider_id' => $railwayProvider['id'],
            'name' => 'too long test railway route name',
        ]);
        $response->assertSessionHasErrors(['name']);
    }

    public function test_get_validation_error_duplicate_token_when_post(): void
    {
        $railwayProviderEventStream = RailwayProviderEventStream::factory()
            ->create();

        $railwayProvider = RailwayProvider::factory()->state([
            'railway_provider_event_stream_id' => $railwayProviderEventStream['id'],
        ])->create();

        $railwayRouteEventStream = RailwayRouteEventStream::factory()
            ->create();

        $storeRailwayRouteRequest = RailwayRouteStoreRequest::factory()
            ->state([
                'railway_route_event_stream_id' => $railwayRouteEventStream['id'],
                'token' => FormToken::make(),
                'valid_from' => Carbon::parse('2024-01-01 00:00:00.000000'),
                'railway_provider_id' => $railwayProvider['id'],
                'name' => '鉄道路線'
            ])
            ->create();

        $response = $this->post('/admin/railway_routes', [
            'token' => $storeRailwayRouteRequest['token'], // duplicate_token
            'valid_from' => '2024-01-01 00:00:00.000000',
            'railway_provider_id' => $railwayProvider['id'],
            'name' => '鉄道路線',
        ]);
        $response->assertSessionHasErrors(['token']);
    }

    public function test_create_store_railway_route_request_when_post(): void
    {
        Event::fake();

        $railwayProviderEventStream = RailwayProviderEventStream::factory()
            ->create();

        $railwayProvider = RailwayProvider::factory()->state([
            'railway_provider_event_stream_id' => $railwayProviderEventStream['id'],
        ])->create();

        $response = $this->post('/admin/railway_routes', [
            'token' => 'target token',
            'valid_from' => '2024-01-01 00:00:00.999999',
            'railway_provider_id' => $railwayProvider['id'],
            'name' => 'target route',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('railway_route_store_requests', [
            'token' => 'target token',
            'valid_from' => '2024-01-01 00:00:00.999999',
            'railway_provider_id' => $railwayProvider['id'],
            'name' => 'target route',
        ]);
        Event::assertDispatched(RailwayRouteStoreRequestCreated::class);
    }
}
