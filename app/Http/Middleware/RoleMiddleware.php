<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$roles): Response
    {
        if (auth()->check() && in_array(auth()->user()->role, $roles)) {
            return $next($request);
        }

        switch (auth()->user()->role) {
            case 'Admin':
                return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
            case 'Karyawan':
                return redirect()->route('peminjaman-barang')->with('error', 'You do not have permission to access this page.');
            default:
                return redirect()->route('auth-login-basic')->with('error', 'You do not have permission to access this page.');
        }
    }
}
