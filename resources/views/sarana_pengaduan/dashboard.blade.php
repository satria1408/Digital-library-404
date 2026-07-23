@extends('layout.app')

@section('content')
<div class="container-fluid py-2">

    <!-- Header Panel Utama -->
    <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom border-secondary border-opacity-10">
        <div>
            <span class="badge bg-info-subtle text-info rounded-pill mb-1 px-2.5 py-1 fw-bold text-uppercase tracking-wider" style="font-size: 0.65rem;">Panel Kendali Laporan</span>
            <h2 class="fw-extrabold mb-0 adaptive-title" style="font-size: 1.75rem; font-weight: 800; letter-spacing: -0.03em;">Ringkasan Sarana Pengaduan</h2>
        </div>
        <div class="text-end d-none d-sm-block">
            <small class="adaptive-muted d-block">Status Penanganan</small>
            <span class="badge bg-info-subtle text-info border border-info border-opacity-25 rounded-pill px-2.5">Pembaruan Otomatis</span>
        </div>
    </div>

    <!-- Alert Notifikasi Sukses -->
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm d-flex align-items-center gap-2 mb-4" style="border-radius: 12px; background-color: #d4edda; color: #155724;">
            <i class="bi bi-check-circle-fill fs-5"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <!-- 1. BARIS STATISTIK UTAMA -->
    <div class="row g-3 mb-4">
        <!-- Antrean -->
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm adaptive-card" style="border-radius: 12px;">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="p-2 bg-warning-subtle text-warning rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="bi bi-hourglass-split fs-5"></i>
                    </div>
                    <div>
                        <span class="adaptive-muted d-block tracking-wide" style="font-size: 0.65rem; font-weight: 700; text-uppercase;">Antrean</span>
                        <h5 class="fw-bold mb-0 adaptive-title" style="font-size: 1.1rem;">
                            {{ $totalAntrean ?? 0 }} <span class="adaptive-muted fs-6 fw-normal">Laporan</span>
                        </h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Diproses -->
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm adaptive-card" style="border-radius: 12px;">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="p-2 bg-primary-subtle text-primary rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="bi bi-gear-fill fs-5"></i>
                    </div>
                    <div>
                        <span class="adaptive-muted d-block tracking-wide" style="font-size: 0.65rem; font-weight: 700; text-uppercase;">Diproses</span>
                        <h5 class="fw-bold mb-0 adaptive-title" style="font-size: 1.1rem;">
                            {{ $totalDiproses ?? 0 }} <span class="adaptive-muted fs-6 fw-normal">Tindak Lanjut</span>
                        </h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Selesai -->
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm adaptive-card" style="border-radius: 12px;">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="p-2 bg-success-subtle text-success rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="bi bi-patch-check-fill fs-5"></i>
                    </div>
                    <div>
                        <span class="adaptive-muted d-block tracking-wide" style="font-size: 0.65rem; font-weight: 700; text-uppercase;">Selesai</span>
                        <h5 class="fw-bold mb-0 adaptive-title" style="font-size: 1.1rem;">
                            {{ $totalSelesai ?? 0 }} <span class="adaptive-muted fs-6 fw-normal">Tuntas</span>
                        </h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ditolak -->
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm adaptive-card" style="border-radius: 12px;">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="p-2 bg-danger-subtle text-danger rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="bi bi-x-circle-fill fs-5"></i>
                    </div>
                    <div>
                        <span class="adaptive-muted d-block tracking-wide" style="font-size: 0.65rem; font-weight: 700; text-uppercase;">Ditolak</span>
                        <h5 class="fw-bold mb-0 adaptive-title" style="font-size: 1.05rem;">
                            {{ $totalDitolak ?? 0 }} <span class="adaptive-muted fs-6 fw-normal">Arsip</span>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. TOMBOL INTERAKTIF NAVIGASI CEPAT -->
    <div class="row g-3 mb-4">
        <!-- Menu Antrean Masuk -->
        <div class="col-12 col-md-4">
            <a href="{{ route('saranapengaduan.admin.index') }}" class="card h-100 border-0 text-decoration-none adaptive-card p-3 luxury-card-interactive" style="border-radius: 16px;">
                <div class="card-body text-center d-flex flex-column align-items-center justify-content-center py-4 position-relative overflow-hidden">
                    <div class="glow-blueprint bg-info"></div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm text-info position-relative" style="width: 65px; height: 65px; background: rgba(13, 202, 240, 0.06); border: 1px solid rgba(13, 202, 240, 0.15);">
                        <i class="bi bi-inboxes-fill fs-2"></i>
                    </div>
                    <h4 class="fw-bold mb-2 position-relative adaptive-title" style="font-size: 1.1rem; letter-spacing: -0.01em;">Daftar Antrean Pengaduan</h4>
                    <p class="adaptive-muted mb-0 small px-2 position-relative">Verifikasi keluhan baru, ubah status penanganan, dan berikan tanggapan penyelesaian.</p>
                </div>
            </a>
        </div>

        {{-- CARD BARU: BALIK KE PERPUSTAKAAN DIGITAL --}}
        <div class="col-12 col-md-4">
            <a href="{{ route('digitallibrary.admin.dashboard') }}" class="card h-100 border-0 text-decoration-none adaptive-card p-3 luxury-card-interactive" style="border-radius: 16px;">
                <div class="card-body text-center d-flex flex-column align-items-center justify-content-center py-4 position-relative overflow-hidden">
                    <div class="glow-blueprint bg-primary"></div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm text-primary position-relative" style="width: 65px; height: 65px; background: rgba(13, 110, 253, 0.06); border: 1px solid rgba(13, 110, 253, 0.15);">
                        <i class="bi bi-book-half fs-2"></i>
                    </div>
                    <h4 class="fw-bold mb-2 position-relative adaptive-title" style="font-size: 1.1rem; letter-spacing: -0.01em;">Perpustakaan Digital</h4>
                    <p class="adaptive-muted mb-0 small px-2 position-relative">Kembali ke dashboard utama perpustakaan sekolah.</p>
                </div>
            </a>
        </div>

        <!-- Menu Log Sistem Keamanan -->
        <div class="col-12 col-md-4">
            <a href="{{ route('security.logs.index') }}" class="card h-100 border-0 text-decoration-none adaptive-card p-3 luxury-card-interactive security-card" style="border-radius: 16px;">
                <div class="card-body text-center d-flex flex-column align-items-center justify-content-center py-4 position-relative overflow-hidden">
                    <div class="glow-blueprint bg-danger"></div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm text-danger position-relative" style="width: 65px; height: 65px; background: rgba(220, 53, 69, 0.06); border: 1px solid rgba(220, 53, 69, 0.15);">
                        <i class="bi bi-shield-lock-fill fs-2"></i>
                    </div>
                    <h4 class="fw-bold mb-2 position-relative text-danger" style="font-size: 1.1rem; letter-spacing: -0.01em;">Security Log</h4>
                    <p class="adaptive-muted mb-0 small px-2 position-relative">Pantau dan kelola log percobaan serangan SQL Injection yang diblokir oleh sistem.</p>
                </div>
            </a>
        </div>
    </div>

</div>

<style>
    .luxury-card-interactive {
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.02) !important;
        transition: all 0.3s cubic-bezier(0.215, 0.610, 0.355, 1);
    }
    .luxury-card-interactive:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.05) !important;
    }
    .luxury-card-interactive:active {
        transform: scale(0.985);
    }
    .luxury-card-interactive.security-card {
        background: rgba(220, 53, 69, .04) !important;
        border: 1px solid rgba(220, 53, 69, .12) !important;
    }
    .glow-blueprint {
        position: absolute;
        width: 100px;
        height: 100px;
        top: -50px;
        right: -50px;
        border-radius: 50%;
        opacity: 0.03;
        filter: blur(20px);
        transition: all 0.3s ease;
    }
    .luxury-card-interactive:hover .glow-blueprint {
        opacity: 0.08;
        transform: scale(1.8);
    }
</style>
@endsection