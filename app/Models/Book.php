<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'isbn',
        'judul',
        'penulis',
        'penerbit',
        'cover_url',
        'kategori',
        'stok'
    ];

    /**
     * Accessor URL Cover - Diperbaiki agar pembacaan storage link akurat
     */
    public function getCoverUrlAttribute($value)
    {
        // 1. Jika data bawaan adalah link URL (dari Google API seeder lama)
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }

        // 2. Jika data bawaan berupa nama file lokal hasil upload manual
        if ($value && Storage::disk('public')->exists('covers/' . $value)) {
            return asset('storage/covers/' . $value);
        }

        // 3. Fallback jika kosong atau file fisik tidak ditemukan
        return 'https://images.unsplash.com/photo-1543002588-bfa74002ed7e?q=80&w=400';
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
}