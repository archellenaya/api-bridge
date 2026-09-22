<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => response()->json(['app' => 'APIBridge', 'status' => 'ok']));

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('platform.login');
    Route::post('/admin/login', [AuthController::class, 'login'])->name('platform.login.submit');
});

Route::middleware('auth:platform')->group(function () {
    Route::get('/admin', [DashboardController::class, 'index'])->name('platform.dashboard');
    Route::get('/admin/tenants', [DashboardController::class, 'tenants'])->name('platform.tenants');
    Route::get('/admin/tenants/create', [DashboardController::class, 'createTenant'])->name('platform.tenants.create');
    Route::post('/admin/tenants', [DashboardController::class, 'storeTenant'])->name('platform.tenants.store');
    Route::get('/admin/tenants/{tenant}/edit', [DashboardController::class, 'editTenant'])->name('platform.tenants.edit');
    Route::put('/admin/tenants/{tenant}', [DashboardController::class, 'updateTenant'])->name('platform.tenants.update');
    Route::post('/admin/logout', [AuthController::class, 'logout'])->name('platform.logout');
});
