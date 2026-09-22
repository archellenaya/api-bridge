<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Platform\PlatformTenant;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tenants = PlatformTenant::query()->latest()->take(10)->get();

        return view('admin.dashboard', [
            'platform' => 'APIBridge',
            'tenant_count' => PlatformTenant::count(),
            'active_tenants' => PlatformTenant::where('status', 'active')->count(),
            'trial_tenants' => PlatformTenant::where('status', 'trial')->count(),
            'tenants' => $tenants,
            'domain' => $request->getHost(),
            'status' => 'ok',
        ]);
    }
}
