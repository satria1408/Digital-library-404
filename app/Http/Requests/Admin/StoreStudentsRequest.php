<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; 
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'nis'   => 'required|numeric|unique:users,nis',
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'kelas' => 'required|string',
        ];
    }

    /**
     * Custom message untuk pesan error validasi.
     */
    public function messages(): array
    {
        return [
            'nis.required'   => 'NIS wajib diisi!',
            'nis.numeric'    => 'NIS harus berupa angka!',
            'nis.unique'     => 'NIS sudah terdaftar!',
            'name.required'  => 'Nama siswa wajib diisi!',
            'email.required' => 'Email wajib diisi!',
            'email.email'    => 'Format email tidak valid!',
            'email.unique'   => 'Email sudah digunakan!',
            'kelas.required' => 'Kelas wajib diisi!',
        ];
    }
}