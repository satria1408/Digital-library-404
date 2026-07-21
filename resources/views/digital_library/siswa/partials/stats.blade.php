@extends('layout.dashboard-siswa')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    
    <!-- Header Halaman -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 fw-bold">Statistik & Riwayat Peminjaman</h1>
            <p class="text-muted small mb-0">Informasi lengkap mengenai jejak digital buku yang kamu baca di perpustakaan.</p>
        </div>
    </div>

    <!-- Tiga Kotak Statistik Atas (Grid Responsif) -->
    <div class="row g-3 mb-4">
        <!-- Total Pernah Dipinjam -->
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 py-2" style="border-left: 4px solid #198754 !important;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1" style="font-size: 0.75rem;">Total Pernah Dipinjam</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $totalPernahDipinjam ?? 0 }} Buku</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-journal-check fs-2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sedang Aktif Dipinjam -->
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 py-2" style="border-left: 4px solid #ffc107 !important;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1" style="font-size: 0.75rem;">Sedang Dipinjam</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $sedangDipinjam ?? 0 }} Buku</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-bookmark-dash fs-2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Denda Berjalan -->
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 py-2" style="border-left: 4px solid #dc3545 !important;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1" style="font-size: 0.75rem;">Denda Berjalan</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">Rp{{ number_format($totalDendaAman ?? 0, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-cash-coin fs-2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Container Utama Riwayat -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="card-header bg-primary text-white d-flex align-items-center py-3 px-4">
            <h5 class="mb-0 fw-bold d-flex align-items-center gap-2" style="font-size: 1.05rem;">
                <i class="bi bi-clock-history"></i> Daftar Riwayat Transaksi Buku
            </h5>
        </div>
        <div class="card-body p-3 p-md-4">
            @if(($myBooks ?? collect())->isEmpty())
                <div class="alert alert-info mb-0 text-center rounded-3">Belum ada catatan riwayat aktivitas peminjaman.</div>
            @else
                
                <!-- TAMPILAN DEKSTOP (d-none d-md-block) -->
                <div class="table-responsive d-none d-md-block">
                    <table class="table align-middle table-hover mb-0">
                        <thead class="table-light text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700;">
                            <tr>
                                <th class="text-center" width="60">No</th>
                                <th>Judul Buku</th>
                                <th width="160">Tanggal Pinjam</th>
                                <th width="160">Tanggal Kembali</th>
                                <th width="160">Kategori</th>
                                <th width="180" class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($myBooks as $index => $trans)
                                <tr>
                                    <td class="text-center fw-bold text-muted">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="shadow-sm rounded border bg-light d-flex align-items-center justify-content-center" style="width: 36px; height: 48px; min-width: 36px;">
                                                <img src="{{ $trans->book->cover_url ?? asset('images/default-cover.jpg') }}" alt="Cover" style="width: 100%; height: 100%; object-fit: cover;">
                                            </div>
                                            <div>
                                                <strong class="text-dark d-block" style="font-size: 0.95rem;">{{ $trans->book->judul ?? 'Buku Telah Dihapus' }}</strong>
                                                <span class="text-muted small text-uppercase" style="font-size: 0.7rem;">Penulis: {{ $trans->book->penulis ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="text-secondary fw-medium">{{ \Carbon\Carbon::parse($trans->tanggal_pinjam)->format('d M Y') }}</span></td>
                                    <td>
                                        <span class="text-secondary fw-medium">
                                            {{ ($trans->status === 'kembali' && $trans->tanggal_kembali) ? \Carbon\Carbon::parse($trans->tanggal_kembali)->format('d M Y') : '-' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border px-2.5 py-1.5 rounded-3" style="font-size: 0.75rem;">
                                            {{ $trans->book->kategori ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($trans->status === 'pending')
                                            <span class="badge bg-secondary text-white rounded-pill px-3 py-1.5 d-block">Pending Admin</span>
                                        @elseif($trans->status === 'pinjam')
                                            <span class="badge bg-warning text-dark rounded-pill px-3 py-1.5 d-block">Dipinjam</span>
                                        @elseif($trans->status === 'kembali')
                                            <span class="badge bg-success text-white rounded-pill px-3 py-1.5 d-block">Dikembalikan</span>
                                        @else
                                            <span class="badge bg-danger text-white rounded-pill px-3 py-1.5 d-block">Terlambat</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- TAMPILAN MOBILE (d-md-none) SINKRON & PREMIUM -->
                <div class="d-md-none px-1 pt-1">
                    @foreach($myBooks as $index => $trans)
                        @php
                            // Tentukan warna border kiri berdasarkan status transaksi riwayat
                            $borderColor = match($trans->status) {
                                'pending' => '#6c757d',
                                'pinjam'  => '#ffc107',
                                'kembali' => '#198754',
                                default   => '#dc3545',
                            };
                        @endphp
                        <div class="card mb-3 border-0 shadow-sm"
                             style="border-left: 4px solid {{ $borderColor }} !important; border-radius: 0 16px 16px 0;">
                            <div class="card-body p-3">

                                <!-- Bagian Atas: Cover & Info Buku -->
                                <div class="d-flex align-items-start gap-3 mb-2.5">
                                    <div class="shadow-sm rounded border bg-light overflow-hidden d-flex align-items-center justify-content-center" style="width: 42px; height: 56px; min-width: 42px;">
                                        <img src="{{ $trans->book->cover_url ?? asset('images/default-cover.jpg') }}" alt="Cover" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                    <div class="overflow-hidden flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start gap-1">
                                            <p class="fw-bold mb-0.5 text-dark" style="font-size: 14px; line-height: 1.3; font-weight: 700;">
                                                {{ $trans->book->judul ?? 'Buku Telah Dihapus' }}
                                            </p>
                                            <span class="text-muted fw-bold small">#{{ $index + 1 }}</span>
                                        </div>
                                        <span class="text-muted small d-block text-truncate" style="font-size: 0.7rem;">Penulis: {{ $trans->book->penulis ?? '-' }}</span>
                                    </div>
                                </div>

                                <!-- Bagian Tengah: Detail Informasi Tanggal -->
                                <div class="mb-3" style="font-size: 12px; color: #6c757d;">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <span style="min-width: 95px;" class="text-secondary">Tanggal Pinjam</span>
                                        <span class="fw-medium text-dark">: {{ \Carbon\Carbon::parse($trans->tanggal_pinjam)->format('d M Y') }}</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <span style="min-width: 95px;" class="text-secondary">Tanggal Kembali</span>
                                        <span class="fw-medium text-dark">
                                            : {{ ($trans->status === 'kembali' && $trans->tanggal_kembali) ? \Carbon\Carbon::parse($trans->tanggal_kembali)->format('d M Y') : '-' }}
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <span style="min-width: 95px;" class="text-secondary">Kategori Buku</span>
                                        <span>: <span class="badge bg-light text-dark border px-2 py-0.5 rounded-2" style="font-size: 10px;">{{ $trans->book->kategori ?? '-' }}</span></span>
                                    </div>
                                </div>

                                <!-- Bagian Bawah: Penanda Badge Status Mobile -->
                                <div>
                                    @if($trans->status === 'pending')
                                        <div class="text-center py-2 bg-light border text-secondary fw-bold rounded-3" style="font-size: 12px;">
                                            ⏳ Pending Admin
                                        </div>
                                    @elseif($trans->status === 'pinjam')
                                        <div class="text-center py-2 bg-warning-subtle text-warning border border-warning border-opacity-25 fw-bold rounded-3" style="font-size: 12px; color: #664d03 !important;">
                                            📖 Sedang Dipinjam
                                        </div>
                                    @elseif($trans->status === 'kembali')
                                        <div class="text-center py-2 bg-success-subtle text-success border border-success border-opacity-25 fw-bold rounded-3" style="font-size: 12px; color: #0f5132 !important;">
                                            ✅ Dikembalikan
                                        </div>
                                    @else
                                        <div class="text-center py-2 bg-danger-subtle text-danger border border-danger border-opacity-25 fw-bold rounded-3" style="font-size: 12px; color: #842029 !important;">
                                            Terlambat
                                        </div>
                                    @endif
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>

            @endif
        </div>
    </div>

</div>
@endsection