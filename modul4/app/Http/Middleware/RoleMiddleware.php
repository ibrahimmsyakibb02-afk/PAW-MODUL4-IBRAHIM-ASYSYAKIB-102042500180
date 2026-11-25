<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Proteksi halaman admin: hanya pengguna dengan role yang sesuai yang boleh lewat.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Pengguna belum login: arahkan ke halaman login
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        // Pengguna sudah login tapi role tidak sesuai: tolak akses
        if (auth()->user()->role !== $role) {
            return redirect()->route('home')
                ->with('error', 'Akses ditolak! Anda tidak memiliki izin untuk mengakses halaman tersebut.');
        }

        return $next($request);
    }
}
