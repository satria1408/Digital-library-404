<?php

namespace App\Models\SaranaPengaduan\Admin;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $table = 'complaints';

    /**
     * Attributes that are mass assignable.
     */
    protected $fillable = [
        'ticket_code',
        'user_id',
        'type',
        'category',
        'description',
        'photo_path',
        'is_anonymous',
        'status',
        'admin_notes',
    ];

    /**
     * Relasi belongsTo ke data Siswa (User) yang membuat laporan
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi hasMany ke Log Akuntabilitas Admin (Satu aduan bisa dilog berkali-kali)
     */
    public function logs()
    {
        return $this->hasMany(ComplaintLog::class, 'complaint_id');
    }
}
