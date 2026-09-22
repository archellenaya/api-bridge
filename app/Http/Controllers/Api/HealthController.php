<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HealthController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'status' => 'ok',
            'app' => 'APIBridge',
            'tenant' => tenant()?->getKey() ?? null,
            'host' => $request->getHost(),
        ]);
    }
}
