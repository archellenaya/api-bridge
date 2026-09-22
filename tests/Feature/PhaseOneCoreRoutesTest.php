<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class PhaseOneCoreRoutesTest extends TestCase
{
    public function test_platform_dashboard_route_is_available(): void
    {
        $this->assertTrue(Route::has('platform.dashboard'));
    }

    public function test_api_health_route_is_available(): void
    {
        $this->assertTrue(Route::has('tenant.health'));
        $this->assertTrue(Route::has('tenant.current'));
    }

    public function test_tenant_health_endpoint_responds_on_localhost_without_tenant_context(): void
    {
        $response = $this->getJson('/api/v1/health');

        $response->assertOk();
        $response->assertJsonPath('status', 'ok');
    }
}
