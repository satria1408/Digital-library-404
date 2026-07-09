<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\DigitalLibrary\Owner\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OwnerController extends Controller
{
    /**
     * Menampilkan halaman dashboard / profil Owner.
     */
    public function index()
    {
        // Mengambil data owner yang sedang login beserta data user utamanya
        $owner = Owner::with('user')->where('user_id', auth()->id())->firstOrFail();

        // return view diarahkan ke sub-folder owner universal lo
        return view('owner.dasboard', compact('owner'));
    }

    /**
     * Mengupdate data profil Owner.
     */
    public function updateProfil(Request $request)
    {
        $owner = Owner::where('user_id', auth()->id())->firstOrFail();
        $user = $owner->user;

        $request->validate([
            'nama_lengkap'  => 'required|string|max:255',
            'no_telepon'    => 'required|string|max:15',
            'alamat_kantor' => 'required|string',
            'password'      => 'nullable|string|min:6|confirmed',
        ]);

        // 1. Update ke tabel users (Universal Auth)
        $user->update([
            'nama_lengkap' => $request->nama_lengkap,
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        // 2. Update ke tabel owners
        $owner->update([
            'no_telepon'    => $request->no_telepon,
            'alamat_kantor' => $request->alamat_kantor,
        ]);

        return redirect()->back()->with('success', 'Profil Owner berhasil diperbarui!');
    }
}