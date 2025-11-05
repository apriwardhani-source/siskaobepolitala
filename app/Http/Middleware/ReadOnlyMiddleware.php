<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ReadOnlyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Allow only safe HTTP methods for read-only sections
        if (!in_array($request->getMethod(), ['GET', 'HEAD', 'OPTIONS'])) {
            abort(405, 'Bagian ini bersifat read-only. Aksi tidak diizinkan.');
        }

        return $next($request);
    }
}

