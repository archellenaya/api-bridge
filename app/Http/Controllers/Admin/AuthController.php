<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return response()->json([
            'message' => 'Platform login required.',
            'login_url' => '/admin/login',
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('platform')->attempt($credentials)) {
            $request->session()->regenerate();

            return response()->json([
                'status' => 'authenticated',
                'redirect' => '/admin',
            ]);
        }

        return response()->json([
            'status' => 'invalid_credentials',
        ], 401);
    }

    public function logout(Request $request)
    {
        Auth::guard('platform')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'status' => 'logged_out',
        ]);
    }
}
