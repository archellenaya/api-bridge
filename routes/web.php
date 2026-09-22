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
    Route::post('/admin/logout', [AuthController::class, 'logout'])->name('platform.logout');
});
