<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'platform' => 'APIBridge',
            'tenant_count' => 0,
            'status' => 'ok',
            'domain' => $request->getHost(),
        ]);
    }
}
