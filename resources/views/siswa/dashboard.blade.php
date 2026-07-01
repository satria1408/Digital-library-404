@extends('layout.dashboard-siswa')

@section('content')
<div class="container-fluid py-3 px-3 px-md-4">
    
    <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom border-secondary border-opacity-10">
        <div>
            <span class="badge bg-primary-subtle text-primary rounded-pill mb-1 px-2.5 py-1 fw-bold text-uppercase tracking-wider" style="font-size: 0.65rem;">Siswa Akses Portal</span>
            <h2 class="fw-extrabold mb-0" style="font-size: 1.75rem; font-weight: 800; letter-spacing: -0.03em;">Pusat Literasi Digital</h2>
        </div>
        <div class="text-end d-none d-sm-block">
            <small class="text-muted d-block">Status Sistem</small>
            <span class="badge bg-success-subtle text-success border border-success border-opacity-25 rounded-pill px-2.5">Terhubung Real-time</span>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm bg-white" style="border-radius: 12px;">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="p-2 bg-primary-subtle text-primary rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="bi bi-bookmarks-fill fs-5"></i>
                    </div>
                    <div>
                        <span class="text-muted d-block tracking-wide" style="font-size: 0.65rem; font-weight: 700; text-uppercase;">Koleksi</span>
                        <h5 class="fw-bold mb-0" style="font-size: 1.1rem;">{{ $totalKoleksi ?? 0 }} <span class="text-muted fs-6 fw-normal">Buku</span></h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm bg-white" style="border-radius: 12px;">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="p-2 bg-success-subtle text-success rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="bi bi-arrow-repeat fs-5"></i>
                    </div>
                    <div>
                        <span class="text-muted d-block tracking-wide" style="font-size: 0.65rem; font-weight: 700; text-uppercase;">Dipinjam</span>
                        <h5 class="fw-bold mb-0" style="font-size: 1.1rem;">{{ $totalDipinjam ?? 0 }} <span class="text-muted fs-6 fw-normal">Aktif</span></h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm bg-white" style="border-radius: 12px;">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="p-2 bg-warning-subtle text-warning rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="bi bi-clock-history fs-5"></i>
                    </div>
                    <div>
                        <span class="text-muted d-block tracking-wide" style="font-size: 0.65rem; font-weight: 700; text-uppercase;">Pending</span>
                        <h5 class="fw-bold mb-0" style="font-size: 1.1rem;">{{ $totalPending ?? 0 }} <span class="text-muted fs-6 fw-normal">Ajuan</span></h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm bg-white" style="border-radius: 12px;">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="p-2 bg-danger-subtle text-danger rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="bi bi-cash-stack fs-5"></i>
                    </div>
                    <div>
                        <span class="text-muted d-block tracking-wide" style="font-size: 0.65rem; font-weight: 700; text-uppercase;">Denda</span>
                        <h5 class="fw-bold text-danger mb-0" style="font-size: 1.05rem;">
                            @if(($totalDendaAman ?? 0) > 0)
                                <span class="fs-6 fw-bold">Rp</span>{{ number_format($totalDendaAman, 0, ',', '.') }}
                            @else
                                Rp 0
                            @endif
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3">

        <div class="col">
            <a href="{{ route('siswa.peminjaman') }}" class="card h-100 border-0 text-decoration-none bg-white p-3 luxury-card-interactive" style="border-radius: 16px;">
                <div class="card-body text-center d-flex flex-column align-items-center justify-content-center py-4 position-relative overflow-hidden">
                    <div class="glow-blueprint bg-primary"></div>
                    
                    <div class="rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm text-primary position-relative" style="width: 65px; height: 65px; background: rgba(13, 110, 253, 0.06); border: 1px solid rgba(13, 110, 253, 0.15);">
                        <i class="bi bi-journal-plus fs-2"></i>
                    </div>
                    <h4 class="fw-bold mb-2 position-relative" style="font-size: 1.1rem; letter-spacing: -0.01em;">Peminjaman Buku</h4>
                    <p class="text-muted mb-0 small px-2 position-relative">Telusuri katalog perpustakaan digital sekolah dan ajukan peminjaman instan.</p>
                </div>
            </a>
        </div>

        <div class="col">
            <a href="{{ route('siswa.pengembalian') }}" class="card h-100 border-0 text-decoration-none bg-white p-3 luxury-card-interactive" style="border-radius: 16px;">
                <div class="card-body text-center d-flex flex-column align-items-center justify-content-center py-4 position-relative overflow-hidden">
                    <div class="glow-blueprint bg-success"></div>
                    
                    <div class="rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm text-success position-relative" style="width: 65px; height: 65px; background: rgba(25, 135, 84, 0.06); border: 1px solid rgba(25, 135, 84, 0.15);">
                        <i class="bi bi-journal-check fs-2"></i>
                    </div>
                    <h4 class="fw-bold mb-2 position-relative" style="font-size: 1.1rem; letter-spacing: -0.01em;">Pengembalian Buku</h4>
                    <p class="text-muted mb-0 small px-2 position-relative">Cek tenggat waktu buku aktif dan kelola pengembalian mandiri secara terjadwal.</p>
                </div>
            </a>
        </div>

        <div class="col">
            <a href="{{ route('wishlist.index') }}" class="card h-100 border-0 text-decoration-none bg-white p-3 luxury-card-interactive wishlist-card" style="border-radius: 16px;">
                <div class="card-body text-center d-flex flex-column align-items-center justify-content-center py-4 position-relative overflow-hidden">
                    <div class="glow-blueprint bg-danger"></div>

                    <div class="rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm text-danger position-relative" style="width: 65px; height: 65px; background: rgba(220, 53, 69, 0.06); border: 1px solid rgba(220, 53, 69, 0.15);">
                        <i class="bi bi-heart-fill fs-2"></i>
                    </div>
                    <h4 class="fw-bold mb-2 position-relative" style="font-size: 1.1rem; letter-spacing: -0.01em;">Wishlist Buku</h4>
                    <p class="text-muted mb-0 small px-2 position-relative">Simpan buku favoritmu dan tandai dengan hati untuk dibaca nanti.</p>
                </div>
            </a>
        </div>

        <div class="col">
            <a href="{{ route('siswa.stats') }}" class="card h-100 border-0 text-decoration-none bg-white p-3 luxury-card-interactive" style="border-radius: 16px;">
                <div class="card-body text-center d-flex flex-column align-items-center justify-content-center py-4 position-relative overflow-hidden">
                    <div class="glow-blueprint bg-info"></div>
                    
                    <div class="rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm text-info position-relative" style="width: 65px; height: 65px; background: rgba(13, 202, 240, 0.06); border: 1px solid rgba(13, 202, 240, 0.15);">
                        <i class="bi bi-bar-chart-line fs-2"></i>
                    </div>
                    <h4 class="fw-bold mb-2 position-relative" style="font-size: 1.1rem; letter-spacing: -0.01em;">Statistik Riwayat</h4>
                    <p class="text-muted mb-0 small px-2 position-relative">Analisis rangkuman data membaca mingguan serta grafik sirkulasi peminjaman.</p>
                </div>
            </a>
        </div>

    </div>
</div>

<style>
    /* Efek Micro-Interaction Premium */
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

    .luxury-card-interactive.wishlist-card {
        background: rgba(220, 53, 69, .04) !important;
        border: 1px solid rgba(220, 53, 69, .12) !important;
    }

    /* Soft Blur Glow effect di belakang card */
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