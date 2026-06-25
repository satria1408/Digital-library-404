@extends('layout.dashboard-siswa')

@section('content')
<div class="container py-4">
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card stat-card shadow-sm">
                <div class="card-body text-center">
                    <h6 class="text-muted">Total Buku</h6>
                    <h2 class="fw-bold mb-0">{{ $books->count() }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card stat-card shadow-sm">
                <div class="card-body text-center">
                    <h6 class="text-muted">Buku Dipinjam</h6>
                    <h2 class="fw-bold mb-0">{{ $myBooks->count() }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card stat-card shadow-sm">
                <div class="card-body text-center">
                    <h6 class="text-muted">Buku Tersedia</h6>
                    <h2 class="fw-bold mb-0">{{ $books->where('stok', '>', 0)->count() }}</h2>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection