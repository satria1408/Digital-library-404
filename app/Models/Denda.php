<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Denda extends Model
{
    protected $fillable = ['transaction_id', 'hari_terlambat', 'nominal', 'status'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public static function hitungNominal(int $hari): int
    {
        return match(true) {
            $hari >= 30 => 10000,
            $hari >= 14 => 8000,
            $hari >= 7  => 5000,
            $hari >= 3  => 2000,
            $hari >= 1  => 1000,
            default     => 0,
        };
    }
}