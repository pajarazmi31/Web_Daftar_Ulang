<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Pastikan user sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. Pastikan user memiliki relasi role dan ambil properti 'nama_role'
        // Kita gunakan optional() atau null-safe operator (?->) agar aman jika relasi kosong
        $userRole = Auth::user()->role?->nama_role;

        // 3. Cek apakah nama_role user ada di dalam daftar role yang diizinkan
        if ($userRole && in_array($userRole, $roles)) {
            return $next($request);
        }

        // Jika tidak cocok, kunci akses (403)
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}