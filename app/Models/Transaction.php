<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    // 1. Tambahkan 'tanggal_deadline' ke dalam $fillable
    protected $fillable = [
        'user_id', 'book_id', 'tanggal_pinjam', 'tanggal_deadline', 'tanggal_kembali', 'status'
    ];

    // 2. Tambahkan $casts agar Laravel otomatis mengubah string tanggal menjadi objek Carbon
    protected $casts = [
        'tanggal_pinjam'   => 'date',
        'tanggal_deadline' => 'date',
        'tanggal_kembali'  => 'date',
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function book() { return $this->belongsTo(Book::class); }
    public function denda() { return $this->hasOne(Denda::class); }

    /**
     * Menghitung jumlah hari keterlambatan
     */
    public function hariTerlambat(): int
    {
        // Jika statusnya sudah kembali, maka tidak terhitung terlambat lagi di dashboard aktif
        if ($this->status === 'kembali') {
            return 0;
        }

        // Hitung selisih hari antara Hari Ini dengan Batas Tanggal Deadline
        // diffInDays dengan parameter false akan menghasilkan angka minus jika sudah lewat deadline
        $hari = (int) Carbon::today()->diffInDays(
            Carbon::parse($this->tanggal_deadline), false
        );

        // Jika hasilnya minus, artinya sudah lewat batas deadline (terlambat)
        // Kita kalikan -1 agar angkanya menjadi positif untuk jumlah hari keterlambatan
        if ($hari < 0) {
            return abs($hari);
        }

        return 0;
    }
}