<?php

namespace Tests\Feature;

use App\Models\Tenant\TenantApiKey;
use App\Models\Tenant\TenantEndpoint;
use App\Models\Tenant\TenantRequestLog;
use App\Models\Tenant\TenantSetting;
use App\Models\Tenant\TenantSource;
use App\Services\Api\EndpointRegistry;
use App\Services\Api\EndpointTransformer;
use App\Services\Api\UsageMetrics;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class PhaseFourApiOrchestrationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('tenant_api_keys', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('key_hash')->unique();
            $table->string('type')->default('read_write');
            $table->timestamp('last_used_at')->nullable();
            $table->timestamps();
        });

        Schema::create('tenant_sources', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->json('config')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('tenant_endpoints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('source_id')->nullable();
            $table->string('slug')->unique();
            $table->string('method')->default('GET');
            $table->string('route');
            $table->json('transform')->nullable();
            $table->boolean('is_enabled')->default(true);
            $table->timestamps();
        });

        Schema::create('tenant_request_logs', function (Blueprint $table) {
            $table->id();
            $table->string('source_name')->nullable();
            $table->string('endpoint_slug')->nullable();
            $table->unsignedInteger('status_code')->nullable();
            $table->json('request')->nullable();
            $table->json('response')->nullable();
            $table->datetime('occurred_at')->nullable();
            $table->timestamps();
        });

        Schema::create('tenant_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->json('value')->nullable();
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('tenant_settings');
        Schema::dropIfExists('tenant_request_logs');
        Schema::dropIfExists('tenant_endpoints');
        Schema::dropIfExists('tenant_sources');
        Schema::dropIfExists('tenant_api_keys');

        parent::tearDown();
    }
    public function test_api_keys_are_supported_and_hash_verified(): void
    {
        $key = TenantApiKey::create([
            'name' => 'Integration Key',
            'key_hash' => TenantApiKey::hashValue('demo-secret'),
            'type' => 'read_write',
        ]);

        $this->assertTrue($key->matches('demo-secret'));
        $this->assertFalse($key->matches('other-secret'));
    }

    public function test_source_registry_and_transformer_support_endpoint_orchestration(): void
    {
        $source = TenantSource::create([
            'name' => 'CRM',
            'type' => 'rest',
            'config' => ['base_url' => 'https://api.example.com'],
            'is_active' => true,
        ]);

        $endpoint = TenantEndpoint::create([
            'source_id' => $source->id,
            'slug' => 'contacts',
            'method' => 'GET',
            'route' => '/contacts',
            'transform' => ['path' => 'data.items'],
            'is_enabled' => true,
        ]);

        $registry = new EndpointRegistry();
        $routes = $registry->forSource($source->id);

        $this->assertCount(1, $routes);
        $this->assertSame('contacts', $routes->first()->slug);

        $transformed = app(EndpointTransformer::class)->apply([
            'data' => ['items' => [['id' => 99]]],
        ], ['path' => 'data.items']);

        $this->assertSame([['id' => 99]], $transformed);
    }

    public function test_request_logs_and_tenant_settings_are_supported(): void
    {
        TenantSetting::set('tenant.api.mode', 'strict');
        $this->assertSame('strict', TenantSetting::get('tenant.api.mode'));

        $log = TenantRequestLog::create([
            'source_name' => 'CRM',
            'endpoint_slug' => 'contacts',
            'status_code' => 200,
            'request' => ['method' => 'GET'],
            'response' => ['status' => 200],
            'occurred_at' => now(),
        ]);

        $this->assertSame(200, $log->status_code);

        $usage = UsageMetrics::capture('contacts.requests', 3);
        $this->assertSame(3, $usage['count']);
    }
}
