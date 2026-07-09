<?php

namespace App\Models\Auth;

use App\Models\DigitalLibrary\Admin\Transaction;
use App\Models\DigitalLibrary\Wishlist;
use App\Models\DigitalLibrary\Owner\Owner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Atribut yang dapat diisi secara massal.
     */
    protected $fillable = [
        'username',
        'nisn',
        'password',
        'nama_lengkap',
        'alamat',
        'role'
    ];

    /**
     * Relasi ke data profil Owner (One-to-One).
     */
    public function owner(): HasOne
    {
        return $this->hasOne(Owner::class, 'user_id');
    }

    /**
     * Relasi ke Transaksi Perpustakaan Digital (One-to-Many).
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'user_id');
    }

    /**
     * Relasi ke Buku Favorit / Wishlist (One-to-Many).
     */
    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class, 'user_id');
    }

    /**
     * Relasi ke Pengajuan Buku Baru (One-to-Many).
     * Catatan: Model ini akan aktif otomatis setelah foldernya lo buat nanti.
     */
    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class, 'user_id');
    }

    /**
     * Atribut yang disembunyikan saat serialisasi data.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting tipe data atribut.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}