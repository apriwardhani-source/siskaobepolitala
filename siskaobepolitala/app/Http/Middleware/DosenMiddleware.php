<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DosenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Kalau belum login, redirect ke login
        if (!Auth::check()) {
            return redirect()->guest(route('login'));
        }

        // Kalau login tapi bukan dosen, kembalikan forbidden
        $user = Auth::user();
        if ($user->role !== 'dosen' && $user->role !== 'admin' && $user->role !== 'tim' && $user->role !== 'kaprodi') {
            abort(403, 'Anda tidak memiliki akses sebagai dosen.');
        }

        return $next($request);
    }
}