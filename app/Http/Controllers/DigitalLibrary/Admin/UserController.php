<?php

namespace App\Http\Controllers\DigitalLibrary\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
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

    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'siswa';

        User::create($validated);

        return redirect()->route('digitallibrary.admin.users.index')->with('success', 'Anggota berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        return view('digital_library.admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, string $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validated();

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('digitallibrary.admin.users.index')->with('success', 'Data anggota diperbarui');
    }

    public function destroy(string $id)
    {
        User::findOrFail($id)->delete();

        return redirect()->route('digitallibrary.admin.users.index')->with('success', 'Anggota berhasil dihapus');
    }
}