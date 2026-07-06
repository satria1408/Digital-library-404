@extends('layout.developer')

@section('content')
<div class="container py-4">
    <!-- Header Welcome Bar -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="p-4 rounded shadow-sm d-flex justify-content-between align-items-center drawer-profile-card">
                <div>
                    <h1 class="fw-bold mb-1" style="font-size: 24px;">
                        Selamat Datang, Chief! <i class="bi bi-wrench-adjustable text-warning"></i>
                    </h1>
                    <p class="text-muted mb-0 small">
                        Halo <strong class="text-warning">{{ auth()->user()->nama_lengkap ?? auth()->user()->username ?? 'developer' }}</strong>, semua sistem berjalan normal. Pantau masukan dan keluhan pengguna di sini.
                    </p>
                </div>
                <div class="text-end">
                    <span class="badge bg-warning text-dark px-3 py-2 font-monospace fw-bold">ROOT ACCESS</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Ringkas Overview (Buku Dihapus, Menjadi 3 Kolom Sejajar) -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="card border shadow-sm rounded p-3 h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-bold text-uppercase">Saran Unread</span>
                    <div class="bg-danger bg-opacity-10 text-danger rounded p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="bi bi-envelope-exclamation-fill fs-4"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1">{{ $stats['belum_dibaca'] ?? 0 }}</h3>
                <small class="text-danger font-monospace">Butuh respons segera</small>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card border shadow-sm rounded p-3 h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-bold text-uppercase">Total Masukan</span>
                    <div class="bg-primary bg-opacity-10 text-primary rounded p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="bi bi-inboxes-fill fs-4"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1">{{ $stats['total_saran'] ?? 0 }}</h3>
                <small class="text-primary font-monospace">Surat masuk database</small>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card border shadow-sm rounded p-3 h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-bold text-uppercase">Total Siswa</span>
                    <div class="bg-success bg-opacity-10 text-success rounded p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="bi bi-people-fill fs-4"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1">{{ $stats['total_siswa'] ?? 0 }}</h3>
                <small class="text-success font-monospace">Pengguna terdaftar</small>
            </div>
        </div>
    </div>

    <!-- Menu Akses Developer -->
    <div class="row g-4">
        <div class="col-md-12">
            <div class="card border shadow-sm rounded">
                <div class="card-header bg-transparent border-0 pt-3 pb-0">
                    <h5 class="fw-bold mb-0"><i class="bi bi-speedometer2 text-warning me-2"></i> Akses Cepat Menu Developer</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted small">
                        Gunakan tautan di bawah ini untuk mengelola lembar aduan sistem, kritik, serta laporan *bug* dari para pengguna aplikasi.
                    </p>
                    <div class="d-grid mt-3">
                        <a href="{{ route('developer.suggestions.index') }}" class="btn btn-primary py-2 fw-bold text-white" style="background: linear-gradient(135deg, #0d6efd, #0a58ca); border: none;">
                            <i class="bi bi-folder2-open me-2"></i> Buka Kotak Saran & Keluhan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection