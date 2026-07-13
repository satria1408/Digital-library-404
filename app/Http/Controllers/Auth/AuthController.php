<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use App\Models\Auth\User;

class AuthController extends Controller
{
    // =========================================================
    // 1. FORM & PROSES LOGIN (SATU PINTU UNIVERSAL)
    // =========================================================

    // Menampilkan satu halaman login untuk semua role
    public function showLogin()
    {
        // Memanggil file: resources/views/auth/login.blade.php
        return view('auth.login');
    }

    // Proses autentikasi semua user (Siswa, Admin, Owner, Developer)
    public function login(Request $request)
    {
        $request->validate([
            'login_input' => 'required', // Di file view, ganti name inputnya jadi name="login_input"
            'password'    => 'required'
        ], [
            'login_input.required' => 'Kolom Username atau NISN wajib diisi!',
            'password.required'    => 'Password wajib diisi!'
        ]);

        $key = 'login-attempt:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'login_input' => "Terlalu banyak percobaan login. Coba lagi dalam {$seconds} detik."
            ]);
        }

        // Otomatis deteksi: Jika input 10 digit angka = NISN (Siswa). Selain itu = Username (Siswa/Admin/Dev/Owner).
        $fieldType = (is_numeric($request->login_input) && strlen($request->login_input) === 10) ? 'nisn' : 'username';

        $credentials = [
            $fieldType => $request->login_input,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            RateLimiter::clear($key);
            $request->session()->regenerate();

            $user = Auth::user();

            // PENGALIHAN OTOMATIS BERDASARKAN ROLE
            if ($user->role === 'siswa') {
                return redirect()->intended('/siswa/dashboard');
            } 
            
            // JALUR CABANG KHUSUS ADMIN (PERPUS VS PENGADUAN)
            elseif ($user->role === 'admin') {
                if ($user->username === 'admin_pengaduan') {
                    return redirect()->intended(route('admin.complaints.dashboard'));
                }
                return redirect()->intended('/admin/dashboard');
            } 
            
            elseif ($user->role === 'owner') {
                return redirect()->intended('/owner/dashboard');
            } elseif ($user->role === 'developer') {
                return redirect()->intended('/developer/dashboard');
            }
        }

        RateLimiter::hit($key, 60);
        return back()->withErrors(['login_input' => 'Username/NISN atau password salah!']);
    }

    // =========================================================
    // 2. REGISTRASI & LOGOUT
    // =========================================================

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nisn'         => 'required|digits:10|unique:users,nisn',
            'username'     => 'required|unique:users|alpha_num|min:4|max:20',
            'password'     => 'required|min:6|confirmed',
            'nama_lengkap' => 'required|string|max:100'
        ], [
            'nisn.digits'  => 'Format NISN harus 10 angka.',
            'nisn.unique'  => 'NISN ini sudah terdaftar.'
        ]);

        User::create([
            'nisn'         => $request->nisn,
            'username'     => $request->username,
            'password'     => Hash::make($request->password),
            'nama_lengkap' => $request->nama_lengkap,
            'role'         => 'siswa'
        ]);

        return redirect('/login')->with('success', 'Berhasil daftar, silakan login!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Semua role kalau logout balik ke satu halaman login yang sama
        return redirect('/login');
    }
}