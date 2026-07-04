<?php

namespace App\Imports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class BukuImport implements
    ToModel,
    WithHeadingRow,
    WithBatchInserts,
    WithChunkReading,
    SkipsOnError,
    SkipsEmptyRows
{
    use SkipsErrors;

    /**
     * Kolom Excel yang dibaca (header baris pertama file, huruf kecil semua):
     *   isbn      -> wajib
     *   judul     -> wajib
     *   penulis   -> opsional
     *   penerbit  -> opsional
     *   kategori  -> opsional
     *   stok      -> opsional, default 1
     *   cover_url -> opsional (link gambar cover, boleh kosong)
     */
    public function model(array $row)
    {
        $isbn  = trim($row['isbn'] ?? '');
        $judul = trim($row['judul'] ?? '');

        // Lewati baris yang ISBN atau judulnya kosong
        if (empty($isbn) || empty($judul)) {
            return null;
        }

        // Lewati kalau ISBN sudah ada di database (hindari duplikat)
        if (Book::where('isbn', $isbn)->exists()) {
            return null;
        }

        return new Book([
            'isbn'      => $isbn,
            'judul'     => $judul,
            'penulis'   => trim($row['penulis'] ?? '') ?: '-',
            'penerbit'  => trim($row['penerbit'] ?? '') ?: '-',
            'kategori'  => trim($row['kategori'] ?? '') ?: '-',
            'stok'      => trim($row['stok'] ?? '') ?: 1,
            'cover_url' => trim($row['cover_url'] ?? '') ?: null,
        ]);
    }

    public function chunkSize(): int
    {
        return 50;
    }

    public function batchSize(): int
    {
        return 50;
    }
}