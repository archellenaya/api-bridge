<?php

namespace Tests\Feature;

use App\Models\Platform\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class PlatformTenantAdminCrudTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('platform_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('platform_tenants', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('status')->default('trial');
            $table->string('owner_email');
            $table->string('database_name')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('platform_tenants');
        Schema::dropIfExists('platform_users');

        parent::tearDown();
    }

    public function test_admin_can_list_and_create_platform_tenants(): void
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('secret'),
        ]);

        $this->actingAs($user, 'platform')
            ->get('/admin/tenants')
            ->assertOk()
            ->assertSee('Tenant management');

        $this->actingAs($user, 'platform')
            ->post('/admin/tenants', [
                'name' => 'Acme Cloud',
                'slug' => 'acme-cloud',
                'status' => 'trial',
                'owner_email' => 'owner@acme.test',
                'database_name' => 'tenant_acme_cloud',
            ])
            ->assertRedirect('/admin/tenants');

        $this->assertDatabaseHas('platform_tenants', [
            'slug' => 'acme-cloud',
            'owner_email' => 'owner@acme.test',
        ]);
    }
}
