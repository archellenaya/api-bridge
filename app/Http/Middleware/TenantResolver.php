<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\InitializeTenancyByRequestData;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

class TenantResolver
{
    public function handle(Request $request, Closure $next)
    {
        if ($this->isPlatformRoute($request) || $this->isPublicTenantRoute($request)) {
            return $next($request);
        }

        if ($request->header('X-Tenant-Id')) {
            return app(InitializeTenancyByRequestData::class)->handle($request, $next);
        }

        if ($request->hasHeader('X-Tenant-Domain') || $request->getHost() !== 'localhost') {
            return app(InitializeTenancyByDomain::class)->handle($request, $next);
        }

        return app(PreventAccessFromCentralDomains::class)->handle($request, $next);
    }

    protected function isPlatformRoute(Request $request): bool
    {
        return $request->is('admin*')
            || $request->is('platform*')
            || $request->is('up')
            || $request->is('/');
    }

    protected function isPublicTenantRoute(Request $request): bool
    {
        return $request->is('api/v1/health')
            || $request->is('api/v1/tenants/current');
    }
}
