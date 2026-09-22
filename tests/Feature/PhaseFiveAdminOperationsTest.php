<?php

namespace Tests\Feature;

use App\Models\Platform\PlatformDomain;
use App\Models\Platform\PlatformSubscription;
use App\Models\Platform\PlatformTenant;
use App\Models\Platform\PlatformSetting;
use App\Models\Platform\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class PhaseFiveAdminOperationsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

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

        Schema::create('platform_domains', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id');
            $table->string('domain')->unique();
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });

        Schema::create('platform_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id');
            $table->string('plan');
            $table->string('status')->default('active');
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();
        });

        Schema::create('platform_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable();
            $table->string('key');
            $table->json('value')->nullable();
            $table->timestamps();
            $table->unique(['tenant_id', 'key']);
        });

        Schema::create('platform_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('platform_users');
        Schema::dropIfExists('platform_settings');
        Schema::dropIfExists('platform_subscriptions');
        Schema::dropIfExists('platform_domains');
        Schema::dropIfExists('platform_tenants');

        parent::tearDown();
    }

    public function test_platform_tenant_subscription_and_domain_management_works(): void
    {
        $tenant = PlatformTenant::create([
            'uuid' => 'tenant-uuid-1',
            'name' => 'Acme',
            'slug' => 'acme',
            'status' => 'trial',
            'owner_email' => 'owner@acme.test',
            'database_name' => 'tenant_acme',
            'metadata' => ['region' => 'us-east'],
        ]);

        $domain = PlatformDomain::create([
            'tenant_id' => $tenant->id,
            'domain' => 'acme.test',
            'is_primary' => true,
        ]);

        $subscription = PlatformSubscription::create([
            'tenant_id' => $tenant->id,
            'plan' => 'starter',
            'status' => 'active',
            'starts_at' => now(),
            'ends_at' => now()->addMonth(),
        ]);

        $this->assertSame('Acme', $tenant->name);
        $this->assertSame('acme.test', $domain->domain);
        $this->assertSame('starter', $subscription->plan);
    }

    public function test_platform_admin_settings_and_roles_are_supported(): void
    {
        PlatformSetting::set(1, 'tenant_limit', 25);

        $this->assertSame(25, PlatformSetting::get(1, 'tenant_limit'));

        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('secret'),
        ]);

        $this->assertTrue($user->exists);
        $this->assertSame('Admin User', $user->name);
    }
}
