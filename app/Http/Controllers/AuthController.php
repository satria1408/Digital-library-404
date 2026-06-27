<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use App\Models\User;


class AuthController extends Controller
{
    // Menampilkan form login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses Login (Sesuai Flowchart: Validasi Login)
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // =========================================================
        // SECURITY: Rate limiting — max 5x percobaan per IP per menit
        // =========================================================
        $key = 'login-attempt:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'username' => "Terlalu banyak percobaan login. Coba lagi dalam {$seconds} detik."
            ]);
        }

        if (Auth::attempt($credentials)) {
            // Reset rate limiter jika login berhasil
            RateLimiter::clear($key);

            $request->session()->regenerate();

            // =========================================================
            // SECURITY: Regenerate session ID setelah login
            // mencegah session fixation attack
            // =========================================================
            $request->session()->migrate(true);

            // Redirect sesuai Role (Flowchart Admin vs Siswa)
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }

            return redirect()->intended('/siswa/dashboard');
        }

        // Tambah hitungan percobaan gagal
        RateLimiter::hit($key, 60);

        return back()->withErrors(['username' => 'Username atau password salah!']);
    }

    // Proses Daftar Anggota (Sesuai Flowchart: "Daftar Anggota")
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username'     => 'required|unique:users|alpha_num|min:4|max:20',
            'password'     => 'required|min:6|confirmed',
            'nama_lengkap' => 'required|string|max:100'
        ]);

        User::create([
            'username'     => $request->username,
            'password'     => Hash::make($request->password),
            'nama_lengkap' => $request->nama_lengkap,
            'role'         => 'siswa' // Default register adalah siswa
        ]);

        return redirect('/login')->with('success', 'Berhasil daftar, silakan login!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}