<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class DriverMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['driver', 'admin'])) {
            abort(403, 'Akses Ditolak. Halaman ini khusus Mitra Driver EcoCycle.');
        }

        return $next($request);
    }
}
