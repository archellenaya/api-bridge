<?php

namespace App\Services\Admin;

use App\Models\Platform\PlatformTenant;

class OperationsDashboard
{
    public function summary(): array
    {
        return [
            'tenants' => PlatformTenant::count(),
            'active' => PlatformTenant::where('status', 'active')->count(),
            'trial' => PlatformTenant::where('status', 'trial')->count(),
        ];
    }
}
