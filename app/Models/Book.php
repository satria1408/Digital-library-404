<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    // Tambahkan 'cover' ke dalam properti fillable
    protected $fillable = [
        'judul', 
        'penulis', 
        'penerbit', 
        'cover', 
        'kategori', 
        'stok'
    ]; 
 
    /**
     * Accessor untuk mendapatkan URL penuh dari cover buku.
     * Otomatis membedakan link URL (seeder) dan nama file lokal (upload).
     * * Dipanggil di view dengan: $book->cover_url
     */
    public function getCoverUrlAttribute()
    {
        // 1. Jika data di database berupa link URL internet utuh (Hasil Seeder)
        if (filter_var($this->cover, FILTER_VALIDATE_URL)) {
            return $this->cover;
        }

        // 2. Jika data berupa nama file dan ada di folder storage lokal (Hasil Upload Admin)
        if ($this->cover && file_exists(public_path('storage/covers/' . $this->cover))) {
            return asset('storage/covers/' . $this->cover);
        }
        
        // 3. Fallback placeholder jika data cover kosong/tidak ditemukan
        return 'https://images.unsplash.com/photo-1543002588-bfa74002ed7e?q=80&w=400';
    }

    /**
     * Relasi ke tabel Transaksi (One to Many)
     */
    public function transactions() { 
        return $this->hasMany(Transaction::class);
    }
}