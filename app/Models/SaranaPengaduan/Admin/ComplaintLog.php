<?php

namespace App\Models\SaranaPengaduan\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Auth\User;

class ComplaintLog extends Model
{
    protected $table = 'complaints_logs';

    /**
     * Attributes that are mass assignable.
     */
    protected $fillable = [
        'complaint_id',
        'changed_by_admin_id',
        'status_from',
        'status_to',
        'notes',
    ];

    /**
     * Relasi balik belongsTo ke data pengaduan utama
     */
    public function complaint()
    {
        return $this->belongsTo(Complaint::class, 'complaint_id');
    }

    /**
     * Relasi belongsTo ke data Admin/Guru yang memproses perubahan status laporan
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'changed_by_admin_id');
    }
}