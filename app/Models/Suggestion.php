<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface; // Import ini untuk kustomisasi format serialize

class Suggestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ticket_code',
        'subjek',
        'isi_saran',
        'reply_developer',
        'status'
    ];

    /**
     * ELOQUENT CASTING:
     * Paksa Laravel untuk selalu mengonversi waktu dari database
     * ke zona waktu Asia/Jakarta saat data diakses.
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * Menyinkronkan zona waktu saat model diubah menjadi Array / JSON (Untuk AJAX lo)
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s');
    }

    // Relasi balik ke User (Siswa/Admin)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}