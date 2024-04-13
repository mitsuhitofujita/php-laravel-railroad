<?php

namespace Tests\Feature;

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

class CreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_html_response_where_create_admin_railway_providers_path(): void
    {
        $response = $this->get('/admin/railway_providers/create');
        $response->assertStatus(200);
    }

    public function test_get_validation_error_too_long_railway_provider_name_when_post(): void
    {
        $response = $this->post('/admin/railway_providers', [
            'token' => 'token 1',
            'valid_from' => '2024-01-01 00:00:00.000000',
            'name' => 'too long test railway provider name',
        ]);
        $response->assertSessionHasErrors(['name']);
    }

    public function test_get_validation_error_duplicate_token_when_post(): void
    {
        $railwayProviderEventStream = RailwayProviderEventStream::factory()
            ->create();
        $storeRailwayProviderRequest = StoreRailwayProviderRequest::factory()
            ->state(function () use ($railwayProviderEventStream) {
                return [
                    'railway_provider_event_stream_id' => $railwayProviderEventStream['id'],
                    'token' => FormToken::make(),
                    'valid_from' => Carbon::parse('2024-01-01 00:00:00.000000'),
                    'name' => 'provider'
                ];
            })
            ->create();

        $response = $this->post('/admin/railway_providers', [
            'token' => $storeRailwayProviderRequest['token'],
            'valid_from' => '2024-01-01 00:00:00.000000',
            'name' => 'existing provider',
        ]);
        $response->assertSessionHasErrors(['token']);
    }

    public function test_create_store_railway_provider_request_when_post(): void
    {
        Event::fake();
        $response = $this->post('/admin/railway_providers', [
            'token' => 'target token',
            'valid_from' => '2024-01-01 00:00:00.999999',
            'name' => 'target provider',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('store_railway_provider_requests', [
            'token' => 'target token',
            'valid_from' => '2024-01-01 00:00:00.999999',
            'name' => 'target provider',
        ]);
        Event::assertDispatched(RailwayProviderStoreRequestCreated::class);
    }
}
