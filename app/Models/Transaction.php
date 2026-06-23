<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id', 'book_id', 'tanggal_pinjam', 'tanggal_kembali', 'status'
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function book() { return $this->belongsTo(Book::class); }

    // Tambahan
    public function denda() { return $this->hasOne(Denda::class); }

    public function hariTerlambat(): int
    {
        if ($this->status === 'kembali' || !$this->tanggal_kembali) {
            return 0;
        }

        $hari = (int) Carbon::today()->diffInDays(
            Carbon::parse($this->tanggal_kembali), false
        ) * -1;

        return max(0, $hari);
    }
}