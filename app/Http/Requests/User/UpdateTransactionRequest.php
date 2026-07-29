<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Mengambil ID user dari Route parameter
        $userId = $this->route('user');

        return [
            'nama_lengkap' => 'required|string|max:255',
            'username'     => 'required|string|max:100|unique:users,username,' . $userId,
            'password'     => 'nullable|string|min:6',
            'alamat'       => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi!',
            'username.required'     => 'Username wajib diisi!',
            'username.unique'       => 'Username sudah digunakan oleh user lain!',
            'password.min'          => 'Password baru minimal berisi 6 karakter!',
        ];
    }
}