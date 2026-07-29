<?php

namespace App\Http\Requests\Admin\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status'          => 'required|string',
            'tanggal_pinjam'  => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ];
    }

    public function messages(): array
    {
        return [
            'status.required'          => 'Status transaksi wajib dipilih!',
            'tanggal_pinjam.required'  => 'Tanggal pinjam wajib diisi!',
            'tanggal_kembali.required' => 'Tanggal deadline pengembalian wajib diisi!',
            'tanggal_kembali.after_or_equal' => 'Tanggal deadline tidak boleh sebelum tanggal pinjam!',
        ];
    }
}