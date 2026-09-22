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
        // Phase 1 placeholder for tenant-aware queue processing.
        // This job is intentionally simple and should later resolve the tenant context.
    }
}
