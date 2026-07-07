@extends('layout.app') 

@section('content')
<div class="container-fluid py-4" style="background: #f8fafc; min-height: 100vh;">
    
    <!-- HEADER DASHBOARD -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-slate-800 fw-bold" style="color: #1e293b;">Monitoring Dashboard</h1>
            <p class="text-muted small mb-0">Selamat datang kembali, <strong>{{ Auth::user()->nama_lengkap }}</strong>. Berikut ringkasan performa sistem hari ini.</p>
        </div>
        <div>
            <span class="badge bg-primary px-3 py-2 rounded-pill fw-semibold shadow-sm">
                <i class="bi bi-shield-check me-1"></i> Role: Owner Management
            </span>
        </div>
    </div>

    <!-- DETAIL PROFIL TAMBAHAN DARI TABEL OWNERS -->
    @if(Auth::user()->owner)
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; background: linear-gradient(135deg, #1e293b, #0f172a); color: #fff;">
        <div class="card-body p-3">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <p class="mb-1 small text-slate-400" style="color: #94a3b8;"><i class="bi bi-building"></i> Lokasi Kantor Otoritas</p>
                    <h5 class="mb-0 fw-bold">{{ Auth::user()->owner->alamat_kantor }}</h5>
                </div>
                <div class="col-md-4 text-md-end mt-2 mt-md-0">
                    <small style="color: #94a3b8;"><i class="bi bi-telephone"></i> Kontak Darurat: </small>
                    <span class="fw-mono text-warning">{{ Auth::user()->owner->no_telepon }}</span>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- COUNTER STATISTIK (HIGHLIGHT MONITORING) -->
    <div class="row g-3 mb-4">
        <!-- TOTAL BUKU -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="rounded-3 p-3 bg-primary bg-opacity-10 text-primary me-3">
                        <i class="bi bi-bookshelf fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted small mb-1 fw-bold text-uppercase" style="letter-spacing: 0.05em;">Total Stok Buku</h6>
                        <h3 class="mb-0 fw-bold text-dark">{{ $totalBuku }} <span class="fs-6 text-muted fw-normal">Eks</span></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- TOTAL SISWA -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="rounded-3 p-3 bg-success bg-opacity-10 text-success me-3">
                        <i class="bi bi-people-fill fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted small mb-1 fw-bold text-uppercase" style="letter-spacing: 0.05em;">Siswa Terdaftar</h6>
                        <h3 class="mb-0 fw-bold text-dark">{{ $totalSiswa }} <span class="fs-6 text-muted fw-normal">User</span></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- TOTAL TRANSAKSI -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="rounded-3 p-3 bg-warning bg-opacity-10 text-warning me-3">
                        <i class="bi bi-arrow-left-right fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted small mb-1 fw-bold text-uppercase" style="letter-spacing: 0.05em;">Sirkulasi Transaksi</h6>
                        <h3 class="mb-0 fw-bold text-dark">{{ $totalTransaksi }} <span class="fs-6 text-muted fw-normal">Log</span></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- KAS DENDA MASUK -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="rounded-3 p-3 bg-danger bg-opacity-10 text-danger me-3">
                        <i class="bi bi-wallet2 fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted small mb-1 fw-bold text-uppercase" style="letter-spacing: 0.05em;">Kas Denda Lunas</h6>
                        <h3 class="mb-0 fw-bold text-danger">Rp {{ number_format($totalDendaMasuk, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- AREA KONTROL DARURAT (FUNGSI UTAMA HYBRID) -->
    <div class="row g-4">
        <!-- SISI KIRI: PANEL AKSES QUICK PREVIEW -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold text-dark mb-1"><i class="bi bi-lightning-charge-fill text-warning"></i> Otoritas Kendali Cepat</h5>
                    <p class="text-muted small">Meskipun bertugas memantau, Anda memegang bypass penuh ke modul operasional jika terjadi urgensi.</p>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="row g-2">
                        <div class="col-6">
                            <a href="#" class="btn btn-outline-primary w-100 py-3 text-start d-flex flex-column rounded-3">
                                <i class="bi bi-journals fs-4 mb-2"></i>
                                <span class="fw-bold">Bypass Buku</span>
                                <span class="small text-muted" style="font-size: 11px;">Intip / Kelola Data Buku</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="#" class="btn btn-outline-success w-100 py-3 text-start d-flex flex-column rounded-3">
                                <i class="bi bi-collection-play fs-4 mb-2"></i>
                                <span class="fw-bold">Bypass Transaksi</span>
                                <span class="small text-muted" style="font-size: 11px;">Konfirmasi pinjaman mandek</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="#" class="btn btn-outline-danger w-100 py-3 text-start d-flex flex-column rounded-3">
                                <i class="bi bi-cash-coin fs-4 mb-2"></i>
                                <span class="fw-bold">Bypass Keuangan</span>
                                <span class="small text-muted" style="font-size: 11px;">Audit riwayat denda siswa</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="#" class="btn btn-outline-secondary w-100 py-3 text-start d-flex flex-column rounded-3">
                                <i class="bi bi-person-lines-fill fs-4 mb-2"></i>
                                <span class="fw-bold">Manajemen User</span>
                                <span class="small text-muted" style="font-size: 11px;">Lihat seluruh akun sistem</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SISI KANAN: STATUS INFORMASI OPERASIONAL -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold text-dark mb-1"><i class="bi bi-info-circle-fill text-primary"></i> Status Operasional</h5>
                </div>
                <div class="card-body px-4">
                    <ul class="list-group list-group-flush small">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <div>
                                <h6 class="mb-0 fw-bold">Sistem Autentikasi</h6>
                                <span class="text-muted style" style="font-size: 11px;">Gerbang Login Terpusat</span>
                            </div>
                            <span class="badge bg-success-subtle text-success border border-success px-2 py-1">Aktif Satu Pintu</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <div>
                                <h6 class="mb-0 fw-bold">Penyimpanan Denda</h6>
                                <span class="text-muted" style="font-size: 11px;">Isolasi Data Keuangan</span>
                            </div>
                            <span class="badge bg-info-subtle text-info border border-info px-2 py-1">Tabel Terpisah</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <div>
                                <h6 class="mb-0 fw-bold">Kotak Saran / Keluhan</h6>
                                <span class="text-muted" style="font-size: 11px;">Hub Tiket Realtime</span>
                            </div>
                            <span class="badge bg-success-subtle text-success border border-success px-2 py-1">Online</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection