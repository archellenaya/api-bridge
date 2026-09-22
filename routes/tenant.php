<?php

declare(strict_types=1);

use App\Http\Controllers\Api\HealthController;
use App\Http\Middleware\TenantResolver;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'api',
    TenantResolver::class,
])->prefix('api/v1')->group(function () {
    Route::get('/health', [HealthController::class, 'index'])->name('tenant.health');
    Route::get('/tenants/current', fn () => response()->json([
        'tenant' => tenant()?->getKey(),
        'name' => tenant()?->name,
        'status' => 'resolved',
    ]))->name('tenant.current');
});
