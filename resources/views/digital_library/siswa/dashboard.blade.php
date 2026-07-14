@extends('layout.dashboard-siswa')

@section('content')
<div class="container-fluid py-3 px-3 px-md-4" x-data="{ openPerpus: false, openPengaduan: false }">
    
    <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom border-secondary border-opacity-10">
        <div>
            <span class="badge bg-primary-subtle text-primary rounded-pill mb-1 px-2.5 py-1 fw-bold text-uppercase tracking-wider" style="font-size: 0.65rem;">OneSchool All-in-One Portal</span>
            <h2 class="fw-extrabold mb-0" style="font-size: 1.75rem; font-weight: 800; letter-spacing: -0.03em;">Portal Layanan Terpadu</h2>
        </div>
        <div class="text-end d-none d-sm-block">
            <small class="text-muted d-block">Status</small>
            <span class="badge bg-success-subtle text-success border border-success border-opacity-25 rounded-pill px-2.5">Online</span>
        </div>
    </div>

    <div class="row g-4 justify-content-center mb-4">

        <div class="col-12 col-md-6 col-lg-5 order-1 order-md-1">
            <div @click="openPerpus = !openPerpus; if(openPerpus) openPengaduan = false" class="card h-100 border-0 text-decoration-none bg-white p-4 luxury-hub-card cursor-pointer" style="border-radius: 20px;">
                <div class="card-body text-center d-flex flex-column align-items-center justify-content-center py-4 position-relative overflow-hidden">
                    <div class="glow-hub bg-primary"></div>
                    
                    <div class="rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm text-primary position-relative" style="width: 80px; height: 80px; background: rgba(13, 110, 253, 0.06); border: 1px solid rgba(13, 110, 253, 0.15);">
                        <i class="bi bi-book-half fs-1"></i>
                    </div>
                    <h3 class="fw-bold mb-2 position-relative text-dark" style="font-size: 1.4rem; letter-spacing: -0.02em;">Perpustakaan Digital</h3>
                    <p class="text-muted mb-0 small px-3 position-relative">Akses katalog buku, pinjam e-book, cek status pengembalian, dan kelola wishlist literasi kamu.</p>
                    
                    <div class="mt-4 btn btn-sm rounded-pill px-4 fw-bold tracking-wide text-uppercase transition-all" :class="openPerpus ? 'btn-primary' : 'btn-outline-primary'" style="font-size: 0.75rem;">
                        <span x-text="openPerpus ? 'Tutup Pilihan ▲' : 'Masuk Modul ▼'"></span>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="openPerpus" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95"
             class="col-12 col-lg-10 order-2 order-md-3">
            <div class="p-4 bg-white rounded-4 border shadow-sm">
                <h5 class="fw-bold text-dark mb-3"><i class="bi bi-layers-half text-primary me-2"></i>Pilih Fitur Perpustakaan:</h5>
                <div class="row g-3">
                    <div class="col-12 col-md-3">
                        <a href="{{ route('siswa.peminjaman') }}" class="btn btn-light w-100 p-3 border rounded-3 text-start sub-menu-item">
                            <div class="d-flex align-items-center">
                                <div class="icon-box bg-primary-subtle text-primary me-3"><i class="bi bi-book"></i></div>
                                <div>
                                    <strong class="d-block text-dark small">Peminjaman Buku</strong>
                                    <span class="text-muted" style="font-size: 0.7rem;">Cari & pinjam</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-md-3">
                        <a href="{{ route('siswa.pengembalian') }}" class="btn btn-light w-100 p-3 border rounded-3 text-start sub-menu-item">
                            <div class="d-flex align-items-center">
                                <div class="icon-box bg-success-subtle text-success me-3"><i class="bi bi-arrow-counterclockwise"></i></div>
                                <div>
                                    <strong class="d-block text-dark small">Pengembalian Buku</strong>
                                    <span class="text-muted" style="font-size: 0.7rem;">Kembalikan katalog</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-md-3">
                        <a href="{{ route('wishlist.index') }}" class="btn btn-light w-100 p-3 border rounded-3 text-start sub-menu-item">
                            <div class="d-flex align-items-center">
                                <div class="icon-box bg-info-subtle text-info me-3"><i class="bi bi-heart"></i></div>
                                <div>
                                    <strong class="d-block text-dark small">Wishlist Buku</strong>
                                    <span class="text-muted" style="font-size: 0.7rem;">Koleksi simpanan</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-md-3">
                        <a href="{{ route('siswa.stats') }}" class="btn btn-light w-100 p-3 border rounded-3 text-start sub-menu-item">
                            <div class="d-flex align-items-center">
                                <div class="icon-box bg-warning-subtle text-warning me-3"><i class="bi bi-bar-chart-line"></i></div>
                                <div>
                                    <strong class="d-block text-dark small">Stats / History</strong>
                                    <span class="text-muted" style="font-size: 0.7rem;">Riwayat baca</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-5 order-3 order-md-2">
            <div @click="openPengaduan = !openPengaduan; if(openPengaduan) openPerpus = false" class="card h-100 border-0 text-decoration-none bg-white p-4 luxury-hub-card cursor-pointer" style="border-radius: 20px;">
                <div class="card-body text-center d-flex flex-column align-items-center justify-content-center py-4 position-relative overflow-hidden">
                    <div class="glow-hub bg-warning"></div>
                    
                    <div class="rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm text-warning position-relative" style="width: 80px; height: 80px; background: rgba(255, 193, 7, 0.06); border: 1px solid rgba(255, 193, 7, 0.15);">
                        <i class="bi bi-chat-left-text-fill fs-1"></i>
                    </div>
                    <h3 class="fw-bold mb-2 position-relative text-dark" style="font-size: 1.4rem; letter-spacing: -0.02em;">Pengaduan & Sarana</h3>
                    <p class="text-muted mb-0 small px-3 position-relative">Laporkan fasilitas rusak, sampaikan keluhan operasional, atau ajukan surat permohonan izin resmi.</p>
                    
                    <div class="mt-4 btn btn-sm rounded-pill px-4 fw-bold tracking-wide text-uppercase transition-all" :class="openPengaduan ? 'btn-warning text-white' : 'btn-outline-warning'" style="font-size: 0.75rem;">
                        <span x-text="openPengaduan ? 'Tutup Pilihan ▲' : 'Masuk Modul ▼'"></span>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="openPengaduan" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95"
             class="col-12 col-lg-10 order-4 order-md-4">
            <div class="p-4 bg-white rounded-4 border shadow-sm">
                <h5 class="fw-bold text-dark mb-3"><i class="bi bi-layers-half text-warning me-2"></i>Pilih Layanan Pengaduan & Sarana:</h5>
                <div class="row g-3">
                    <div class="col-12 col-md-4">
                        <a href="{{ route('siswa.complaints.create') }}" class="btn btn-light w-100 p-3 border rounded-3 text-start sub-menu-item">
                            <div class="d-flex align-items-center">
                                <div class="icon-box bg-warning-subtle text-warning me-3"><i class="bi bi-pencil-square"></i></div>
                                <div>
                                    <strong class="d-block text-dark small">Buat Laporan</strong>
                                    <span class="text-muted" style="font-size: 0.7rem;">Ajukan keluhan baru</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-md-4">
                        <a href="{{ route('siswa.complaints.index') }}" class="btn btn-light w-100 p-3 border rounded-3 text-start sub-menu-item">
                            <div class="d-flex align-items-center">
                                <div class="icon-box bg-primary-subtle text-primary me-3"><i class="bi bi-clock-history"></i></div>
                                <div>
                                    <strong class="d-block text-dark small">Riwayat Laporan</strong>
                                    <span class="text-muted" style="font-size: 0.7rem;">Daftar aduan kamu</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-md-4">
                        <a href="#" class="btn btn-light w-100 p-3 border rounded-3 text-start sub-menu-item">
                            <div class="d-flex align-items-center">
                                <div class="icon-box bg-success-subtle text-success me-3"><i class="bi bi-shield-check"></i></div>
                                <div>
                                    <strong class="d-block text-dark small">Informasi Sarpras</strong>
                                    <span class="text-muted" style="font-size: 0.7rem;">Status fasilitas sekolah</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style>
    .cursor-pointer { cursor: pointer; }
    .luxury-hub-card {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02) !important;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        border: 1px solid rgba(0, 0, 0, 0.03) !important;
    }
    .luxury-hub-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06) !important;
    }
    .order-1 .luxury-hub-card:hover { border-color: rgba(13, 110, 253, 0.2) !important; }
    .order-3 .luxury-hub-card:hover { border-color: rgba(255, 193, 7, 0.3) !important; }
    .glow-hub {
        position: absolute; width: 140px; height: 140px; top: -70px; right: -70px; border-radius: 50%; opacity: 0.02; filter: blur(30px); transition: all 0.4s ease;
    }
    .luxury-hub-card:hover .glow-hub { opacity: 0.07; transform: scale(2.2); }
    .icon-box { width: 38px; height: 38px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
    .sub-menu-item { transition: all 0.2s ease; }
    .sub-menu-item:hover {
        background-color: #fff !important;
        border-color: rgba(13, 110, 253, 0.4) !important;
        transform: translateY(-2px);
        box-shadow: 0 5px 10px rgba(0,0,0,0.05);
    }
</style>
@endsection