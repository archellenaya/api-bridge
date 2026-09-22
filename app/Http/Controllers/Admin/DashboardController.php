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

    public function tenants()
    {
        $tenants = PlatformTenant::query()->latest()->get();

        return view('admin.tenants.index', [
            'tenants' => $tenants,
        ]);
    }

    public function createTenant()
    {
        return view('admin.tenants.form', [
            'tenant' => null,
            'mode' => 'create',
        ]);
    }

    public function storeTenant(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:platform_tenants,slug'],
            'status' => ['required', 'in:trial,active,paused,suspended'],
            'owner_email' => ['required', 'email'],
            'database_name' => ['nullable', 'string', 'max:255'],
        ]);

        $validated['uuid'] = (string) \Illuminate\Support\Str::uuid();

        PlatformTenant::create($validated);

        return redirect()->route('platform.tenants')->with('success', 'Tenant created successfully.');
    }

    public function editTenant(PlatformTenant $tenant)
    {
        return view('admin.tenants.form', [
            'tenant' => $tenant,
            'mode' => 'edit',
        ]);
    }

    public function updateTenant(Request $request, PlatformTenant $tenant)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:platform_tenants,slug,' . $tenant->id],
            'status' => ['required', 'in:trial,active,paused,suspended'],
            'owner_email' => ['required', 'email'],
            'database_name' => ['nullable', 'string', 'max:255'],
        ]);

        $tenant->update($validated);

        return redirect()->route('platform.tenants')->with('success', 'Tenant updated successfully.');
    }
}
