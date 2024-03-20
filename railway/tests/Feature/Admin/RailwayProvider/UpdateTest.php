<?php

namespace Tests\Feature;

use App\Events\UpdateRailwayProviderRequestCreated;
use Database\Seeders\Test\Admin\RailwayProvider\FixedSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(FixedSeeder::class);
    }

    public function test_get_html_response_where_edit_admin_railway_providers_path(): void
    {
        $response = $this->get('/admin/railway_providers/1000/edit');
        $response->assertStatus(200);
    }

    public function test_get_validation_error_too_long_railway_provider_name_when_put(): void
    {
        $response = $this->put('/admin/railway_providers/1000', [
            'token' => 'token 1',
            'name' => 'test railway provider name',
        ]);
        $response->assertSessionHasErrors(['name']);
    }

    public function test_get_validation_error_duplicate_token_when_put(): void
    {
        $response = $this->put('/admin/railway_providers/1000', [
            'token' => 'token',
            'name' => 'provider 2',
        ]);
        $response->assertSessionHasErrors(['token']);
    }

    public function test_create_update_railway_provider_request_when_put(): void
    {
        Event::fake();
        $response = $this->put('/admin/railway_providers/1000', [
            'token' => 'token 3',
            'name' => 'provider 3',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('update_railway_provider_requests', [
            'name' => 'provider 3',
        ]);
        Event::assertDispatched(UpdateRailwayProviderRequestCreated::class);
    }
}
