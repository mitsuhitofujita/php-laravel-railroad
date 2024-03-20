<?php

namespace Tests\Feature;

use App\Events\StoreRailwayProviderRequestCreated;
use App\Listeners\CreateRailwayProviderFromStoreRequest;
use Database\Seeders\Test\Admin\RailwayProvider\FixedSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
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
            'token' => 'token',
            'name' => 'test railway provider name',
        ]);
        $response->assertSessionHasErrors(['name']);
    }

    public function test_get_validation_error_duplicate_token_when_post(): void
    {
        $this->seed(FixedSeeder::class);
        $response = $this->post('/admin/railway_providers', [
            'token' => 'token',
            'name' => 'provider 2',
        ]);
        $response->assertSessionHasErrors(['token']);
    }

    public function test_create_store_railway_provider_request_when_post(): void
    {
        Event::fake();
        $response = $this->post('/admin/railway_providers', [
            'token' => 'token',
            'name' => 'provider 1',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('store_railway_provider_requests', [
            'name' => 'provider 1',
        ]);
        Event::assertDispatched(StoreRailwayProviderRequestCreated::class);
    }
}
