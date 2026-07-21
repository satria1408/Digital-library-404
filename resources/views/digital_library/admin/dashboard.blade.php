@extends('layout.app')

@section('content')
<div class="container-fluid py-3 px-3 px-md-4">

    <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom border-secondary border-opacity-10">
        <div>
            <span class="badge bg-primary-subtle text-primary rounded-pill mb-1 px-2.5 py-1 fw-bold text-uppercase tracking-wider" style="font-size: 0.65rem;">Admin Akses Portal</span>
            <h2 class="fw-extrabold mb-0" style="font-size: 1.75rem; font-weight: 800; letter-spacing: -0.03em;">Pusat Kendali Perpustakaan</h2>
        </div>
        <div class="text-end d-none d-sm-block">
            <small class="text-muted d-block">Status Sistem</small>
            <span class="badge bg-success-subtle text-success border border-success border-opacity-25 rounded-pill px-2.5">Terhubung Real-time</span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm d-flex align-items-center gap-2 mb-4 animate__animated animate__fadeIn" style="border-radius: 12px; background-color: #d4edda; color: #155724;">
            <i class="bi bi-check-circle-fill fs-5"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if($errors->has('file_excel'))
        <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center gap-2 mb-4 animate__animated animate__fadeIn" style="border-radius: 12px; background-color: #f8d7da; color: #721c24;">
            <i class="bi bi-exclamation-triangle-fill fs-5"></i>
            <div>{{ $errors->first('file_excel') }}</div>
        </div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm bg-white" style="border-radius: 12px;">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="p-2 bg-primary-subtle text-primary rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="bi bi-book-half fs-5"></i>
                    </div>
                    <div>
                        <span class="text-muted d-block tracking-wide" style="font-size: 0.65rem; font-weight: 700; text-uppercase;">Koleksi</span>
                        <h5 class="fw-bold mb-0" style="font-size: 1.1rem;">{{ $totalBuku ?? 0 }} <span class="text-muted fs-6 fw-normal">Buku</span></h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm bg-white" style="border-radius: 12px;">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="p-2 bg-info-subtle text-info rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="bi bi-people-fill fs-5"></i>
                    </div>
                    <div>
                        <span class="text-muted d-block tracking-wide" style="font-size: 0.65rem; font-weight: 700; text-uppercase;">Anggota</span>
                        <h5 class="fw-bold mb-0" style="font-size: 1.1rem;">{{ $totalAnggota ?? 0 }} <span class="text-muted fs-6 fw-normal">Siswa</span></h5>
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
                        <span class="text-muted d-block tracking-wide" style="font-size: 0.65rem; font-weight: 700; text-uppercase;">Transaksi</span>
                        <h5 class="fw-bold mb-0" style="font-size: 1.1rem;">{{ $totalTransaksiAktif ?? 0 }} <span class="text-muted fs-6 fw-normal">Aktif</span></h5>
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
                            @if(($totalDendaBelumLunas ?? 0) > 0)
                                <span class="fs-6 fw-bold">Rp</span>{{ number_format($totalDendaBelumLunas, 0, ',', '.') }}
                            @else
                                Rp 0
                            @endif
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">

        <div class="col-12 col-sm-6 col-lg-3">
            <a href="{{ route('digitallibrary.admin.books.index') }}" class="card h-100 border-0 text-decoration-none bg-white p-3 luxury-card-interactive" style="border-radius: 16px;">
                <div class="card-body text-center d-flex flex-column align-items-center justify-content-center py-4 position-relative overflow-hidden">
                    <div class="glow-blueprint bg-primary"></div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm text-primary position-relative" style="width: 65px; height: 65px; background: rgba(13, 110, 253, 0.06); border: 1px solid rgba(13, 110, 253, 0.15);">
                        <i class="bi bi-book-half fs-2"></i>
                    </div>
                    <h4 class="fw-bold mb-2 position-relative" style="font-size: 1.1rem; letter-spacing: -0.01em;">Kelola Data Buku</h4>
                    <p class="text-muted mb-0 small px-2 position-relative">Tambah, edit, hapus dan kelola data buku perpustakaan.</p>
                </div>
            </a>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <a href="{{ route('digitallibrary.admin.users.index') }}" class="card h-100 border-0 text-decoration-none bg-white p-3 luxury-card-interactive" style="border-radius: 16px;">
                <div class="card-body text-center d-flex flex-column align-items-center justify-content-center py-4 position-relative overflow-hidden">
                    <div class="glow-blueprint bg-info"></div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm text-info position-relative" style="width: 65px; height: 65px; background: rgba(13, 202, 240, 0.06); border: 1px solid rgba(13, 202, 240, 0.15);">
                        <i class="bi bi-people-fill fs-2"></i>
                    </div>
                    <h4 class="fw-bold mb-2 position-relative" style="font-size: 1.1rem; letter-spacing: -0.01em;">Kelola Anggota</h4>
                    <p class="text-muted mb-0 small px-2 position-relative">Manajemen data anggota dan siswa perpustakaan.</p>
                </div>
            </a>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <a href="{{ route('digitallibrary.admin.transactions.index') }}" class="card h-100 border-0 text-decoration-none bg-white p-3 luxury-card-interactive" style="border-radius: 16px;">
                <div class="card-body text-center d-flex flex-column align-items-center justify-content-center py-4 position-relative overflow-hidden">
                    <div class="glow-blueprint bg-success"></div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm text-success position-relative" style="width: 65px; height: 65px; background: rgba(25, 135, 84, 0.06); border: 1px solid rgba(25, 135, 84, 0.15);">
                        <i class="bi bi-arrow-left-right fs-2"></i>
                    </div>
                    <h4 class="fw-bold mb-2 position-relative" style="font-size: 1.1rem; letter-spacing: -0.01em;">Laporan Transaksi</h4>
                    <p class="text-muted mb-0 small px-2 position-relative">Lihat riwayat peminjaman dan pengembalian buku.</p>
                </div>
            </a>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <a href="{{ route('security.logs.index') }}" class="card h-100 border-0 text-decoration-none bg-white p-3 luxury-card-interactive security-card" style="border-radius: 16px;">
                <div class="card-body text-center d-flex flex-column align-items-center justify-content-center py-4 position-relative overflow-hidden">
                    <div class="glow-blueprint bg-danger"></div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm text-danger position-relative" style="width: 65px; height: 65px; background: rgba(220, 53, 69, 0.06); border: 1px solid rgba(220, 53, 69, 0.15);">
                        <i class="bi bi-shield-lock-fill fs-2"></i>
                    </div>
                    <h4 class="fw-bold mb-2 position-relative" style="font-size: 1.1rem; letter-spacing: -0.01em;">Security Log</h4>
                    <p class="text-muted mb-0 small px-2 position-relative">Pantau dan kelola log percobaan SQL Injection yang terdeteksi sistem.</p>
                </div>
            </a>
        </div>

    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-white" style="border-radius: 16px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="p-2 bg-primary-subtle text-primary rounded-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="bi bi-file-earmark-excel-fill fs-4"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-0" style="font-size: 1.2rem; letter-spacing: -0.02em;">Fitur Super Admin: Otomatisasi Input 100 Buku / Menit</h4>
                            <p class="text-muted mb-0 small">Scan barcode atau kumpulkan nomor ISBN di file Excel, upload di sini, dan biarkan sistem bekerja otomatis di latar belakang.</p>
                        </div>
                    </div>
                    
                    <hr class="border-secondary border-opacity-10 my-3">

                    <form action="{{ route('digitallibrary.admin.buku.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row align-items-end g-3">
                            <div class="col-12 col-md-8">
                                <label for="file_excel" class="form-label small fw-bold text-muted text-uppercase tracking-wider">Pilih File Excel (.xlsx / .xls / .csv)</label>
                                <div class="input-group">
                                    <input type="file" class="form-control border-secondary border-opacity-25" name="file_excel" id="file_excel" required style="border-radius: 8px 0 0 8px;">
                                    <span class="input-group-text bg-light text-muted small"><i class="bi bi-cloud-upload"></i></span>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <button type="submit" class="btn btn-primary w-100 fw-bold py-2 d-flex align-items-center justify-content-center gap-2" style="border-radius: 8px; transition: all 0.2s;">
                                    <i class="bi bi-lightning-charge-fill"></i> Mulai Import Massal
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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

    .luxury-card-interactive.security-card {
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

@push('scripts')
<script src="{{ asset('admin/js/dashboard.js') }}"></script>
@endpush

@endsection