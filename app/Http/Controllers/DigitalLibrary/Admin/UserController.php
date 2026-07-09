<?php

namespace App\Http\Controllers\DigitalLibrary\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'siswa');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%'.$request->search.'%')
                    ->orWhere('username', 'like', '%'.$request->search.'%')
                    ->orWhere('alamat', 'like', '%'.$request->search.'%');
            });
        }

        $users = $query->get();

        return view('digital_library.admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('digital_library.admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
            'alamat' => 'nullable',
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'alamat' => $request->alamat,
            'role' => 'siswa',
        ]);

        return redirect()->route('users.index')->with('success', 'Anggota berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        return view('digital_library.admin.users.edit', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required',
            'username' => 'required|unique:users,username,'.$user->id,
            'alamat' => 'nullable',
        ]);

        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'alamat' => $request->alamat,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Data anggota diperbarui');
    }

    public function destroy(string $id)
    {
        User::findOrFail($id)->delete();

        return redirect()->route('users.index')->with('success', 'Anggota berhasil dihapus');
    }
}
