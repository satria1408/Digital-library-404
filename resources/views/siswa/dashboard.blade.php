@extends('layout.dashboard-siswa')

@section('content')
<div class="container py-4">
    <div class="dashboard-header mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h1 class="fw-bold mb-1">Dashboard Siswa</h1>
            <p class="text-secondary mb-0">Kelola peminjaman dan pengembalian buku</p>
        </div>
        <button id="themeBtn" class="btn btn-dark btn-sm" onclick="document.body.classList.toggle('dark-mode')">
            Toggle Dark Mode
        </button>
    </div>

    <div class="alert alert-info mb-4">
        Selamat datang di Dashboard Siswa. Silakan pilih menu di bawah ini untuk mengelola buku.
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <a href="{{ route('siswa.peminjaman') }}" class="text-decoration-none">
                <div class="card shadow-sm h-100 border-0 bg-primary text-white">
                    <div class="card-body text-center py-4">
                        <h4 class="fw-bold mb-1">Peminjaman Buku</h4>
                        <p class="mb-0 text-white-50 small">Cari dan pinjam buku baru</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('siswa.pengembalian') }}" class="text-decoration-none">
                <div class="card shadow-sm h-100 border-0 bg-success text-white">
                    <div class="card-body text-center py-4">
                        <h4 class="fw-bold mb-1">Pengembalian Buku</h4>
                        <p class="mb-0 text-white-50 small">Lihat & kembalikan buku dipinjam</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('siswa.stats') }}" class="text-decoration-none">
                <div class="card shadow-sm h-100 border-0 bg-info text-white">
                    <div class="card-body text-center py-4">
                        <h4 class="fw-bold mb-1">Statistik Buku</h4>
                        <p class="mb-0 text-white-50 small">Lihat data rangkuman buku</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection