<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class SecurityLog extends Model
{
    protected $fillable = [
        'user_id',
        'ip_address',
        'url',
        'method',
        'payload',
        'attack_type',
        'user_agent',
    ];

    /**
     * Relasi ke user (jika user sedang login)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}