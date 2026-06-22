<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class AuthController extends Controller
{
     // Menampilkan form login 
    public function showLogin() { 
        return view('auth.login'); 
    } 
 
    // Proses Login (Sesuai Flowchart: Validasi Login) 
    public function login(Request $request) { 
        $credentials = $request->validate([ 
            'username' => 'required', 
            'password' => 'required' 
        ]); 
 
        if (Auth::attempt($credentials)) { 
            $request->session()->regenerate(); 
            // Redirect sesuai Role (Flowchart Admin vs Siswa) 
            if (Auth::user()->role === 'admin') { 
                return redirect()->intended('/admin/dashboard'); 
            } 
            return redirect()->intended('/siswa/dashboard'); 
        } 
 
        return back()->withErrors(['username' => 'Username atau password salah!']); 
    } 
 
    // Proses Daftar Anggota (Sesuai Flowchart: "Daftar Anggota") 
    public function showRegister() { 
        return view('auth.register'); 
    } 
 
    public function register(Request $request) { 
        $request->validate([ 
            'username' => 'required|unique:users', 
            'password' => 'required|min:6', 
            'nama_lengkap' => 'required' 
        ]); 
 
        User::create([ 
            'username' => $request->username, 
            'password' => Hash::make($request->password), 
            'nama_lengkap' => $request->nama_lengkap, 
            'role' => 'siswa' // Default register adalah siswa 
        ]); 
 
        return redirect('/login')->with('success', 'Berhasil daftar, silakan login!'); 
    } 
 
    public function logout(Request $request) { 
        Auth::logout(); 
        $request->session()->invalidate(); 
        $request->session()->regenerateToken(); 
        return redirect('/login'); 
    } 
} 

