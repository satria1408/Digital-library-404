<?php

namespace App\Exports;

use App\Models\DigitalLibrary\Admin\Denda;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;

class DendaBulananExport implements FromView
{
    protected int $bulan;
    protected int $tahun;

    public function __construct(int $bulan, int $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function view(): View
    {
        $dendas = Denda::with(['transaction.user', 'transaction.book'])
            ->whereYear('created_at', $this->tahun)
            ->whereMonth('created_at', $this->bulan)
            ->orderBy('created_at')
            ->get();

        // Kelompokkan per tanggal (format Y-m-d) supaya di file Excel
        // ada pembatas/header per tanggal, sesuai request:
        // "tanggal 1 siapa aja yang kena denda, tanggal 2 siapa aja"
        $grouped = $dendas->groupBy(function ($denda) {
            return Carbon::parse($denda->created_at)->format('Y-m-d');
        });

        $namaBulan = Carbon::create($this->tahun, $this->bulan, 1)->translatedFormat('F Y');

        return view('digital_library.admin.dendas.exports', [
            'grouped'   => $grouped,
            'namaBulan' => $namaBulan,
        ]);
    }
}