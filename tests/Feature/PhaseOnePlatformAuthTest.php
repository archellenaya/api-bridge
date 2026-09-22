<?php

namespace Tests\Feature;

use App\Models\Platform\User;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class PhaseOnePlatformAuthTest extends TestCase
{
    public function test_platform_admin_auth_routes_are_registered(): void
    {
        $this->assertTrue(Route::has('platform.login'));
        $this->assertTrue(Route::has('platform.dashboard'));
        $this->assertTrue(Route::has('platform.logout'));
    }

    public function test_platform_auth_provider_is_configured(): void
    {
        $this->assertSame('platform', config('auth.defaults.guard'));
        $this->assertSame(User::class, config('auth.providers.platform_users.model'));
    }
}
