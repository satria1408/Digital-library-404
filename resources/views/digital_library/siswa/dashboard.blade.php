@extends('layout.dashboard-siswa')

@section('content')
<div class="container-fluid py-3 px-3 px-md-4">
    
    <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom border-secondary border-opacity-10">
        <div>
            <span class="badge bg-primary-subtle text-primary rounded-pill mb-1 px-2.5 py-1 fw-bold text-uppercase tracking-wider" style="font-size: 0.65rem;">OneSchool All-in-One Portal</span>
            <h2 class="fw-extrabold mb-0" style="font-size: 1.75rem; font-weight: 800; letter-spacing: -0.03em;">Portal Layanan Terpadu</h2>
        </div>
        <div class="text-end d-none d-sm-block">
            <small class="text-muted d-block">Status Ekosistem</small>
            <span class="badge bg-success-subtle text-success border border-success border-opacity-25 rounded-pill px-2.5">Sistem Aktif</span>
        </div>
    </div>

    <div class="row g-4 justify-content-center">

        <div class="col-12 col-md-6 col-lg-5">
            <a href="{{ route('siswa.digital_library.index') }}" class="card h-100 border-0 text-decoration-none bg-white p-4 luxury-hub-card" style="border-radius: 20px;">
                <div class="card-body text-center d-flex flex-column align-items-center justify-content-center py-4 position-relative overflow-hidden">
                    <div class="glow-hub bg-primary"></div>
                    
                    <div class="rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm text-primary position-relative" style="width: 80px; height: 80px; background: rgba(13, 110, 253, 0.06); border: 1px solid rgba(13, 110, 253, 0.15);">
                        <i class="bi bi-book-half fs-1"></i>
                    </div>
                    <h3 class="fw-bold mb-2 position-relative text-dark" style="font-size: 1.4rem; letter-spacing: -0.02em;">Perpustakaan Digital</h3>
                    <p class="text-muted mb-0 small px-3 position-relative">Akses katalog buku, pinjam e-book, cek status pengembalian, dan kelola wishlist literasi kamu.</p>
                    
                    <div class="mt-4 btn btn-sm btn-primary rounded-pill px-4 fw-bold tracking-wide text-uppercase" style="font-size: 0.75rem;">
                        Masuk Modul <i class="bi bi-arrow-right ms-1"></i>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-12 col-md-6 col-lg-5">
            <a href="#" class="card h-100 border-0 text-decoration-none bg-white p-4 luxury-hub-card" style="border-radius: 20px;">
                <div class="card-body text-center d-flex flex-column align-items-center justify-content-center py-4 position-relative overflow-hidden">
                    <div class="glow-hub bg-warning"></div>
                    
                    <div class="rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm text-warning position-relative" style="width: 80px; height: 80px; background: rgba(255, 193, 7, 0.06); border: 1px solid rgba(255, 193, 7, 0.15);">
                        <i class="bi bi-chat-left-text-fill fs-1"></i>
                    </div>
                    <h3 class="fw-bold mb-2 position-relative text-dark" style="font-size: 1.4rem; letter-spacing: -0.02em;">Pengaduan & Sarana</h3>
                    <p class="text-muted mb-0 small px-3 position-relative">Laporkan fasilitas rusak, sampaikan keluhan operasional, atau ajukan surat permohonan izin resmi.</p>
                    
                    <div class="mt-4 btn btn-sm btn-outline-warning rounded-pill px-4 fw-bold tracking-wide text-uppercase" style="font-size: 0.75rem;">
                        Buka Layanan <i class="bi bi-arrow-right ms-1"></i>
                    </div>
                </div>
            </a>
        </div>

    </div>
</div>

<style>
    /* Efek Micro-Interaction Hub Premium */
    .luxury-hub-card {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02) !important;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        border: 1px solid rgba(0, 0, 0, 0.03) !important;
    }
    
    .luxury-hub-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06) !important;
        border-color: rgba(0, 0, 0, 0.08) !important;
    }

    .luxury-hub-card:active {
        transform: scale(0.98);
    }

    /* Glow effect raksasa untuk halaman Hub */
    .glow-hub {
        position: absolute;
        width: 140px;
        height: 140px;
        top: -70px;
        right: -70px;
        border-radius: 50%;
        opacity: 0.02;
        filter: blur(30px);
        transition: all 0.4s ease;
    }

    .luxury-hub-card:hover .glow-hub {
        opacity: 0.07;
        transform: scale(2.2);
    }
</style>
@endsection