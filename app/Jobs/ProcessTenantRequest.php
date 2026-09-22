<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessTenantRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $tenantId,
        public string $route,
        public array $payload = [],
    ) {}

    public function handle(): void
    {
        $tenant = tenant();

        if ($tenant && $tenant->getKey() !== $this->tenantId) {
            tenancy()->initialize(tenancy()->find($this->tenantId));
        }

        $tag = config('tenancy.cache.tag_base', 'tenant') . ':' . $this->tenantId;

        cache()->tags([$tag])->put('last_route', $this->route, 60);
    }
}
