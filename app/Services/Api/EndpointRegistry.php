<?php

namespace App\Services\Api;

use App\Models\Tenant\TenantEndpoint;
use Illuminate\Database\Eloquent\Collection;

class EndpointRegistry
{
    public function forSource(int $sourceId): Collection
    {
        return TenantEndpoint::query()
            ->where('source_id', $sourceId)
            ->where('is_enabled', true)
            ->orderBy('slug')
            ->get();
    }
}
