@extends('layout.app')

@section('content')
<div class="container-fluid py-3 px-3 px-md-4" x-data="{ openDigilib: false, openPengaduan: false, openSecurity: false }">

    <!-- Header Portal -->
    <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom border-secondary border-opacity-10">
        <div>
            <span class="badge bg-primary-subtle text-primary rounded-pill mb-1 px-2.5 py-1 fw-bold text-uppercase tracking-wider" style="font-size: 0.65rem;">Admin All-in-One Portal</span>
            <h2 class="fw-extrabold mb-0 page-title-text" style="font-size: 1.75rem; font-weight: 800; letter-spacing: -0.03em;">Pusat Kendali Sekolah</h2>
        </div>
        <div class="text-end d-none d-sm-block">
            <small class="text-muted d-block">Status Sistem</small>
            <span class="badge bg-success-subtle text-success border border-success border-opacity-25 rounded-pill px-2.5">Terhubung Real-time</span>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm d-flex align-items-center gap-2 mb-4" style="border-radius: 12px;">
            <i class="bi bi-check-circle-fill fs-5"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if($errors->has('file_excel'))
        <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center gap-2 mb-4" style="border-radius: 12px;">
            <i class="bi bi-exclamation-triangle-fill fs-5"></i>
            <div>{{ $errors->first('file_excel') }}</div>
        </div>
    @endif

    <!-- Cards Row -->
    <div class="row g-4 mb-3">

        {{-- ===== KARTU 1: PERPUSTAKAAN DIGITAL ===== --}}
        <div class="col-12 col-md-4">
            <div @click="openDigilib = !openDigilib; openPengaduan = false; openSecurity = false"
                 class="card h-100 border-0 text-decoration-none custom-dashboard-card p-4 luxury-hub-card cursor-pointer" style="border-radius: 20px;">
                <div class="card-body text-center d-flex flex-column align-items-center justify-content-center py-4 position-relative overflow-hidden">
                    <div class="glow-hub bg-primary"></div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm text-primary position-relative" style="width: 70px; height: 70px; background: rgba(13, 110, 253, 0.1); border: 1px solid rgba(13, 110, 253, 0.2);">
                        <i class="bi bi-book-half fs-2"></i>
                    </div>
                    <h4 class="fw-bold mb-2 position-relative card-heading" style="font-size: 1.2rem; letter-spacing: -0.02em;">Perpustakaan Digital</h4>
                    <p class="card-subtext mb-0 small px-2 position-relative">Kelola koleksi buku, anggota, transaksi, dan denda.</p>
                    <div class="mt-3 btn btn-sm rounded-pill px-4 fw-bold tracking-wide text-uppercase" :class="openDigilib ? 'btn-primary' : 'btn-outline-primary'" style="font-size: 0.72rem;">
                        <span x-text="openDigilib ? 'Tutup ▲' : 'Masuk Modul ▼'"></span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== KARTU 2: SARANA PENGADUAN ===== --}}
        <div class="col-12 col-md-4">
            <div @click="openPengaduan = !openPengaduan; openDigilib = false; openSecurity = false"
                 class="card h-100 border-0 text-decoration-none custom-dashboard-card p-4 luxury-hub-card cursor-pointer" style="border-radius: 20px;">
                <div class="card-body text-center d-flex flex-column align-items-center justify-content-center py-4 position-relative overflow-hidden">
                    <div class="glow-hub bg-warning"></div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm text-warning position-relative" style="width: 70px; height: 70px; background: rgba(255, 193, 7, 0.1); border: 1px solid rgba(255, 193, 7, 0.2);">
                        <i class="bi bi-chat-left-text-fill fs-2"></i>
                        @if(($totalPengaduanBaru ?? 0) > 0)
                            <span class="position-absolute badge rounded-pill bg-danger" style="top: -2px; right: -2px; font-size: 0.6rem;">{{ $totalPengaduanBaru }}</span>
                        @endif
                    </div>
                    <h4 class="fw-bold mb-2 position-relative card-heading" style="font-size: 1.2rem; letter-spacing: -0.02em;">Pengaduan & Sarana</h4>
                    <p class="card-subtext mb-0 small px-2 position-relative">Kelola laporan keluhan siswa dan fasilitas rusak.</p>
                    <div class="mt-3 btn btn-sm rounded-pill px-4 fw-bold tracking-wide text-uppercase" :class="openPengaduan ? 'btn-warning text-white' : 'btn-outline-warning'" style="font-size: 0.72rem;">
                        <span x-text="openPengaduan ? 'Tutup ▲' : 'Masuk Modul ▼'"></span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== KARTU 3: SECURITY LOG ===== --}}
        <div class="col-12 col-md-4">
            <div @click="openSecurity = !openSecurity; openDigilib = false; openPengaduan = false"
                 class="card h-100 border-0 text-decoration-none custom-dashboard-card p-4 luxury-hub-card cursor-pointer" style="border-radius: 20px;">
                <div class="card-body text-center d-flex flex-column align-items-center justify-content-center py-4 position-relative overflow-hidden">
                    <div class="glow-hub bg-danger"></div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm text-danger position-relative" style="width: 70px; height: 70px; background: rgba(220, 53, 69, 0.1); border: 1px solid rgba(220, 53, 69, 0.2);">
                        <i class="bi bi-shield-lock-fill fs-2"></i>
                    </div>
                    <h4 class="fw-bold mb-2 position-relative card-heading" style="font-size: 1.2rem; letter-spacing: -0.02em;">Security Log</h4>
                    <p class="card-subtext mb-0 small px-2 position-relative">Monitoring percobaan serangan SQL Injection.</p>
                    <div class="mt-3 btn btn-sm rounded-pill px-4 fw-bold tracking-wide text-uppercase" :class="openSecurity ? 'btn-danger text-white' : 'btn-outline-danger'" style="font-size: 0.72rem;">
                        <span x-text="openSecurity ? 'Tutup ▲' : 'Masuk Modul ▼'"></span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ===== PANEL MEKAR: PERPUSTAKAAN DIGITAL ===== --}}
    <div x-show="openDigilib"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         class="mb-4">
        <div class="p-4 custom-dashboard-card rounded-4 border shadow-sm">
            <h5 class="fw-bold card-heading mb-3"><i class="bi bi-layers-half text-primary me-2"></i>Ringkasan Perpustakaan Digital</h5>

            <div class="row g-2 mb-3">
                <div class="col-6 col-md-3">
                    <div class="p-2 custom-stat-box rounded-3 text-center">
                        <span class="card-subtext d-block" style="font-size: 0.65rem; font-weight: 700; text-transform: uppercase;">Koleksi</span>
                        <span class="fw-bold card-heading" style="font-size: 1.05rem;">{{ $totalBuku ?? 0 }} Buku</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="p-2 custom-stat-box rounded-3 text-center">
                        <span class="card-subtext d-block" style="font-size: 0.65rem; font-weight: 700; text-transform: uppercase;">Anggota</span>
                        <span class="fw-bold card-heading" style="font-size: 1.05rem;">{{ $totalAnggota ?? 0 }} Siswa</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="p-2 custom-stat-box rounded-3 text-center">
                        <span class="card-subtext d-block" style="font-size: 0.65rem; font-weight: 700; text-transform: uppercase;">Transaksi Aktif</span>
                        <span class="fw-bold card-heading" style="font-size: 1.05rem;">{{ $totalTransaksiAktif ?? 0 }}</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="p-2 custom-stat-box rounded-3 text-center">
                        <span class="card-subtext d-block" style="font-size: 0.65rem; font-weight: 700; text-transform: uppercase;">Denda</span>
                        <span class="fw-bold text-danger" style="font-size: 0.95rem;">Rp {{ number_format($totalDendaBelumLunas ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-6 col-md-3">
                    <a href="{{ route('digitallibrary.admin.books.index') }}" class="btn custom-sub-button w-100 p-3 border rounded-3 text-start sub-menu-item">
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-primary-subtle text-primary me-3"><i class="bi bi-journal-plus"></i></div>
                            <div><strong class="d-block card-heading small">Kelola Buku</strong><span class="card-subtext" style="font-size: 0.7rem;">CRUD koleksi</span></div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="{{ route('digitallibrary.admin.users.index') }}" class="btn custom-sub-button w-100 p-3 border rounded-3 text-start sub-menu-item">
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-success-subtle text-success me-3"><i class="bi bi-people-fill"></i></div>
                            <div><strong class="d-block card-heading small">Kelola Anggota</strong><span class="card-subtext" style="font-size: 0.7rem;">Data siswa</span></div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="{{ route('digitallibrary.admin.transactions.index') }}" class="btn custom-sub-button w-100 p-3 border rounded-3 text-start sub-menu-item">
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-info-subtle text-info me-3"><i class="bi bi-arrow-left-right"></i></div>
                            <div><strong class="d-block card-heading small">Transaksi</strong><span class="card-subtext" style="font-size: 0.7rem;">Peminjaman</span></div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="{{ route('digitallibrary.admin.dendas.index') }}" class="btn custom-sub-button w-100 p-3 border rounded-3 text-start sub-menu-item">
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-warning-subtle text-warning me-3"><i class="bi bi-cash-stack"></i></div>
                            <div><strong class="d-block card-heading small">Denda</strong><span class="card-subtext" style="font-size: 0.7rem;">Kelola bayar</span></div>
                        </div>
                    </a>
                </div>
            </div>

            <hr class="my-4 border-secondary border-opacity-25">

            <h6 class="fw-bold card-heading mb-2"><i class="bi bi-file-earmark-excel text-success me-2"></i>Import Buku Massal</h6>
            <form action="{{ route('digitallibrary.admin.buku.import') }}" method="POST" enctype="multipart/form-data" class="d-flex flex-column flex-md-row gap-2 align-items-md-center">
                @csrf
                <input type="file" name="file_excel" class="form-control form-control-sm custom-input" accept=".xlsx,.xls,.csv" required>
                <button type="submit" class="btn btn-success btn-sm px-3"><i class="bi bi-upload me-1"></i> Import</button>
            </form>
        </div>
    </div>

    {{-- ===== PANEL MEKAR: SARANA PENGADUAN ===== --}}
    <div x-show="openPengaduan"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         class="mb-4">
        <div class="p-4 custom-dashboard-card rounded-4 border shadow-sm">
            <h5 class="fw-bold card-heading mb-3"><i class="bi bi-layers-half text-warning me-2"></i>Ringkasan Sarana Pengaduan</h5>

            <div class="row g-2 mb-3">
                <div class="col-4">
                    <div class="p-2 custom-stat-box rounded-3 text-center">
                        <span class="card-subtext d-block" style="font-size: 0.65rem; font-weight: 700; text-transform: uppercase;">Antrean</span>
                        <span class="fw-bold card-heading" style="font-size: 1.05rem;">{{ $totalPengaduanBaru ?? 0 }}</span>
                    </div>
                </div>
                <div class="col-4">
                    <div class="p-2 custom-stat-box rounded-3 text-center">
                        <span class="card-subtext d-block" style="font-size: 0.65rem; font-weight: 700; text-transform: uppercase;">Diproses</span>
                        <span class="fw-bold card-heading" style="font-size: 1.05rem;">{{ $totalPengaduanDiproses ?? 0 }}</span>
                    </div>
                </div>
                <div class="col-4">
                    <div class="p-2 custom-stat-box rounded-3 text-center">
                        <span class="card-subtext d-block" style="font-size: 0.65rem; font-weight: 700; text-transform: uppercase;">Selesai</span>
                        <span class="fw-bold card-heading" style="font-size: 1.05rem;">{{ $totalPengaduanSelesai ?? 0 }}</span>
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-6 col-md-4">
                    <a href="{{ route('saranapengaduan.admin.dashboard') }}" class="btn custom-sub-button w-100 p-3 border rounded-3 text-start sub-menu-item">
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-warning-subtle text-warning me-3"><i class="bi bi-speedometer2"></i></div>
                            <div><strong class="d-block card-heading small">Dashboard Pengaduan</strong><span class="card-subtext" style="font-size: 0.7rem;">Ringkasan detail</span></div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-4">
                    <a href="{{ route('saranapengaduan.admin.index') }}" class="btn custom-sub-button w-100 p-3 border rounded-3 text-start sub-menu-item">
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-primary-subtle text-primary me-3"><i class="bi bi-card-list"></i></div>
                            <div><strong class="d-block card-heading small">Daftar Laporan</strong><span class="card-subtext" style="font-size: 0.7rem;">Semua aduan</span></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== PANEL MEKAR: SECURITY LOG ===== --}}
    <div x-show="openSecurity"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         class="mb-4">
        <div class="p-4 custom-dashboard-card rounded-4 border shadow-sm">
            <h5 class="fw-bold card-heading mb-3"><i class="bi bi-layers-half text-danger me-2"></i>Ringkasan Security Log</h5>

            <div class="row g-2 mb-3">
                <div class="col-12 col-md-4">
                    <div class="p-3 custom-stat-box rounded-3 text-center">
                        <span class="card-subtext d-block" style="font-size: 0.65rem; font-weight: 700; text-transform: uppercase;">Total Percobaan SQL Injection</span>
                        <span class="fw-bold text-danger" style="font-size: 1.4rem;">{{ $totalSecurityLog ?? 0 }}</span>
                    </div>
                </div>
            </div>

            <a href="{{ route('security.logs.index') }}" class="btn btn-outline-danger px-4 rounded-pill fw-bold">
                Lihat Semua Log <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>

</div>

<style>
    .cursor-pointer { cursor: pointer; }

    /* Styling Dinamis Light / Dark Mode */
    .page-title-text { color: var(--app-text-main, #0f172a); }
    
    .custom-dashboard-card {
        background-color: #ffffff !important;
        border-color: #e2e8f0 !important;
    }
    .card-heading { color: #0f172a !important; }
    .card-subtext { color: #64748b !important; }

    .custom-stat-box {
        background-color: #f8fafc !important;
        border: 1px solid #e2e8f0;
    }

    .custom-sub-button {
        background-color: #f8fafc !important;
        border-color: #e2e8f0 !important;
    }

    /* Override Dark Mode */
    body.dark-mode .custom-dashboard-card {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }
    body.dark-mode .card-heading { color: #f8fafc !important; }
    body.dark-mode .card-subtext { color: #94a3b8 !important; }

    body.dark-mode .custom-stat-box {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }

    body.dark-mode .custom-sub-button {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }

    body.dark-mode .custom-input {
        background-color: #0f172a !important;
        color: #f8fafc !important;
        border-color: #334155 !important;
    }

    /* Hub Card Hover Animation */
    .luxury-hub-card {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02) !important;
        transition: all 0.3s ease;
    }
    .luxury-hub-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1) !important;
    }
    .glow-hub {
        position: absolute; width: 140px; height: 140px; top: -70px; right: -70px; border-radius: 50%; opacity: 0.02; filter: blur(30px); transition: all 0.4s ease;
    }
    .luxury-hub-card:hover .glow-hub { opacity: 0.1; transform: scale(2); }
    .icon-box { width: 38px; height: 38px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
    
    .sub-menu-item { transition: all 0.2s ease; }
    .sub-menu-item:hover {
        border-color: #0d6efd !important;
        transform: translateY(-2px);
    }
</style>
@endsection