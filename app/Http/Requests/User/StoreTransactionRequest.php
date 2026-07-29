<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id'          => 'required|exists:users,id',
            'book_id'          => 'required|exists:books,id',
            'tanggal_pinjam'   => 'required|date',
            'tanggal_kembali'  => 'required|date|after_or_equal:tanggal_pinjam',
            'status'           => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required'         => 'Siswa peminjam wajib dipilih!',
            'user_id.exists'           => 'Siswa tidak ditemukan!',
            'book_id.required'         => 'Buku wajib dipilih!',
            'book_id.exists'           => 'Buku tidak ditemukan!',
            'tanggal_pinjam.required'  => 'Tanggal pinjam wajib diisi!',
            'tanggal_kembali.required' => 'Tanggal deadline pengembalian wajib diisi!',
            'tanggal_kembali.after_or_equal' => 'Tanggal deadline tidak boleh sebelum tanggal pinjam!',
            'status.required'          => 'Status transaksi wajib dipilih!',
        ];
    }
}