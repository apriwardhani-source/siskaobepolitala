<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->guest(route('login'));
        }

        $user = Auth::user();
        
        // Debug logging
        \Log::info('TimMiddleware Debug', [
            'user_id' => $user->id,
            'user_role' => $user->role,
            'user_status' => $user->status,
            'expected_role' => 'tim'
        ]);

        if ($user->role !== 'tim') {
            \Log::warning('Access Denied: Role Mismatch', [
                'user_id' => $user->id,
                'current_role' => $user->role,
                'required_role' => 'tim'
            ]);
            abort(403, 'Akses ditolak. Halaman ini hanya untuk Tim. Role Anda: ' . $user->role);
        }

        return $next($request);
    }
}