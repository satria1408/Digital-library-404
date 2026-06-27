<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Belum login — lempar ke halaman login
        if (!Auth::check()) {
            return redirect()->route('login')
                             ->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        // Login tapi role tidak sesuai — lempar ke dashboard sesuai role aslinya
        // Mencegah siswa akses /admin/** dan sebaliknya
        if ($user->role !== $role) {
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            if ($user->role === 'siswa') {
                return redirect()->route('siswa.dashboard');
            }

            // Role tidak dikenal — paksa logout
            Auth::logout();
            return redirect()->route('login')
                             ->with('error', 'Role tidak valid. Silakan login kembali.');
        }

        return $next($request);
    }
}