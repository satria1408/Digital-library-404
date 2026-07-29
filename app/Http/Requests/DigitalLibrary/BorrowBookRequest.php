<?php

namespace App\Http\Requests\DigitalLibrary;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\DigitalLibrary\Admin\Book;

class BorrowBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Pastikan hanya user logged-in yang bisa ajukan pinjam
        return turn;
    }

    public function rules(): array
    {
        return [
            // Kalau misal ada input durasi pinjam dari form, taro di sini.
            // Untuk ID buku dari route, validasinya bisa pakai custom logic atau biarkan diproses
        ];
    }

    /**
     * Pengecekan tambahan sebelum controller diproses
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $bookId = $this->route('book_id'); // Mengambil $book_id dari URL route
            $book = Book::find($bookId);

            if (!$book) {
                $validator->errors()->add('book', 'Buku tidak ditemukan!');
            } elseif ($book->stok < 1) {
                $validator->errors()->add('stok', 'Stok buku ini sedang habis!');
            }
        });
    }
}