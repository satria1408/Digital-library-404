<?php

namespace App\Http\Requests\Admin\Book;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Mengambil ID buku dari Route parameter untuk pengecualian unique ISBN
        $bookId = $this->route('id');

        return [
            'isbn'      => 'required|string|max:50|unique:books,isbn,' . $bookId,
            'judul'     => 'required|string|max:255',
            'penulis'   => 'required|string|max:255',
            'penerbit'  => 'required|string|max:255',
            'kategori'  => 'nullable|string|max:100',
            'stok'      => 'required|integer|min:0',
            'cover_url' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'isbn.required'      => 'ISBN wajib diisi!',
            'isbn.unique'        => 'ISBN sudah digunakan oleh buku lain!',
            'judul.required'     => 'Judul buku wajib diisi!',
            'penulis.required'   => 'Nama penulis wajib diisi!',
            'penerbit.required'  => 'Nama penerbit wajib diisi!',
            'stok.required'      => 'Jumlah stok wajib diisi!',
            'stok.integer'       => 'Stok harus berupa angka!',
            'cover_url.image'    => 'File sampul harus berupa gambar!',
            'cover_url.mimes'    => 'Format gambar harus jpeg, jpg, png, atau webp!',
            'cover_url.max'      => 'Ukuran gambar maksimal 2MB!',
        ];
    }
}