<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    // Relasi balik ke User (Siswa/Admin)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}