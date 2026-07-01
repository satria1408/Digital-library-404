<?php

namespace App\Http\Controllers\Denda;

use App\Http\Controllers\Controller;
use App\Models\Denda;
use App\Models\Transaction;
use Carbon\Carbon;

class DendaController extends Controller
{
    /**
     * Logic terisolasi untuk menghitung total denda
     */
    public function hitungTotalDenda($myBorrowedBooks)
    {
        $totalDendaAman = 0;

        foreach ($myBorrowedBooks as $trans) {
            $deadline = $trans->tanggal_deadline
                ? Carbon::parse($trans->tanggal_deadline)
                : null;

            if ($deadline && Carbon::today()->gt($deadline)) {
                $hariTerlambat = Carbon::today()->diffInDays($deadline);

                $dendaPerHari = match (true) {
                    $hariTerlambat >= 30 => 10000,
                    $hariTerlambat >= 14 => 8000,
                    $hariTerlambat >= 7  => 5000,
                    $hariTerlambat >= 3  => 2000,
                    $hariTerlambat >= 1  => 1000,
                    default              => 0,
                };

                $totalDendaAman += ($hariTerlambat * $dendaPerHari);
            }
        }

        return $totalDendaAman;
    }
}