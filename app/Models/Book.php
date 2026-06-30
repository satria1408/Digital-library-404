<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'judul',
        'penulis',
        'penerbit',
        'cover',
        'kategori',
        'stok'
    ];

    /**
     * Accessor URL Cover
     */
    public function getCoverUrlAttribute()
    {
        if (filter_var($this->cover, FILTER_VALIDATE_URL)) {
            return $this->cover;
        }

        if ($this->cover && file_exists(public_path('storage/covers/' . $this->cover))) {
            return asset('storage/covers/' . $this->cover);
        }

        return 'https://images.unsplash.com/photo-1543002588-bfa74002ed7e?q=80&w=400';
    }

    /**
     * Relasi Transaction
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Relasi Wishlist
     */
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
}