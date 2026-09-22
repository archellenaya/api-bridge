<?php

namespace Tests\Feature;

use App\Jobs\ProcessTenantRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class PhaseThreeQueueCacheTest extends TestCase
{
    public function test_queue_and_cache_defaults_use_redis(): void
    {
        $this->assertSame('redis', config('queue.default'));
        $this->assertSame('redis', config('cache.default'));
    }

    public function test_process_tenant_request_uses_tenant_context_metadata(): void
    {
        $job = new ProcessTenantRequest(tenantId: 42, route: '/v1/demo', payload: ['foo' => 'bar']);

        $this->assertSame(42, $job->tenantId);
        $this->assertSame('/v1/demo', $job->route);
        $this->assertSame(['foo' => 'bar'], $job->payload);
    }
}
