@extends('layout.dashboard-siswa')

@push('styles')
<style>
    .chunk-kategori-container {
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }

    .chunk-kategori-container::-webkit-scrollbar {
        display: none;
    }

    .transition-all {
        transition: all 0.25s ease-in-out;
    }

    tr.transition-all:hover {
        background-color: rgba(220, 53, 69, 0.02) !important;
    }

    .mobile-dash-line {
        border-top: 1px dashed #e2e8f0;
        opacity: 1;
    }
</style>
@endpush

@section('content')
<div class="container py-2">

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 d-flex flex-row align-items-center gap-3 bg-white">
                <div class="p-2.5 rounded-3 bg-danger-subtle text-danger d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                    <i class="bi bi-heart-fill fs-5"></i>
                </div>
                <div>
                    <span class="text-muted small d-block" style="font-size: 0.75rem; font-weight: 500;">Total Wishlist</span>
                    <h5 class="fw-bold mb-0 text-dark">{{ $books->total() }} Buku</h5>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 d-flex flex-row align-items-center gap-3 bg-white">
                <div class="p-2.5 rounded-3 bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                    <i class="bi bi-check-circle-fill fs-5"></i>
                </div>
                <div>
                    <span class="text-muted small d-block" style="font-size: 0.75rem; font-weight: 500;">Tersedia Dipinjam</span>
                    <h5 class="fw-bold mb-0 text-success">{{ $books->where('stok', '>', 0)->count() }} Buku</h5>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 d-none d-md-block">
            <div class="card border-0 shadow-sm rounded-4 p-3 d-flex flex-row align-items-center gap-3 bg-white">
                <div class="p-2.5 rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                    <i class="bi bi-info-circle-fill fs-5"></i>
                </div>
                <div>
                    <span class="text-muted small d-block" style="font-size: 0.75rem; font-weight: 500;">Info</span>
                    <h5 class="fw-bold mb-0 text-dark" style="font-size: 0.95rem;">Simpan buku favoritmu di sini</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">

        <div class="card-header bg-white border-bottom border-light d-flex justify-content-between align-items-center py-3 px-4">
            <div>
                <h5 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2" style="letter-spacing: -0.01em;">
                    <i class="bi bi-heart-fill text-danger"></i> Wishlist Buku Favorit
                </h5>
                <p class="text-muted small mb-0 d-none d-md-block mt-0.5">Buku yang kamu tandai untuk dibaca nanti.</p>
            </div>
            <a href="{{ route('digitallibrary.siswa.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 fw-medium">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="card-body p-0">

            <div class="p-3 bg-light bg-opacity-50 border-bottom border-light">
                <form action="{{ route('digitallibrary.siswa.wishlist.index') }}" method="GET" id="searchFilterForm">
                    <input type="hidden" name="kategori" id="filterKategoriInput" value="{{ request('kategori') }}">

                    <div class="row g-2">
                        <div class="col-12">
                            <div class="position-relative">
                                <span class="position-absolute top-50 translate-middle-y ms-3 text-muted">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" name="search" class="form-control rounded-pill ps-5 bg-white border-light shadow-none"
                                       placeholder="Ketik judul buku, penulis, atau penerbit lalu tekan enter..."
                                       value="{{ request('search') }}" style="font-size: 0.88rem; height: 42px;">
                                @if(request('search') || request('kategori'))
                                    <span class="position-absolute top-50 translate-middle-y end-0 me-3">
                                        <a href="{{ route('digitallibrary.siswa.wishlist.index') }}" class="btn btn-light btn-sm rounded-pill py-0.5 px-2 text-xs text-danger" style="font-size: 0.75rem;">
                                            <i class="bi bi-x-circle-fill"></i> Reset Filter
                                        </a>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            @if($kategoris->count())
            <div class="px-4 py-3 bg-white border-bottom border-light">
                <span class="text-muted small d-block mb-2 fw-bold text-uppercase" style="font-size: 0.68rem; letter-spacing: 0.05em;">Pilih Kategori Buku:</span>
                <div class="d-flex gap-2 overflow-auto pb-1 chunk-kategori-container" style="white-space: nowrap;">

                    <button type="button" onclick="filterByKategori('')"
                            class="btn btn-sm rounded-pill px-3 transition-all {{ !request('kategori') ? 'btn-danger fw-semibold shadow-sm' : 'btn-light text-secondary' }}" style="font-size: 0.82rem;">
                        Semua Wishlist
                    </button>

                    @foreach($kategoris as $k)
                        <button type="button" onclick="filterByKategori('{{ $k }}')"
                                class="btn btn-sm rounded-pill px-3 transition-all {{ request('kategori') == $k ? 'btn-danger fw-semibold shadow-sm' : 'btn-light text-secondary' }}" style="font-size: 0.82rem;">
                            {{ $k }}
                        </button>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="table-responsive d-none d-lg-block">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-uppercase text-secondary" style="font-size: 0.72rem; font-weight: 700; letter-spacing: 0.05em;">
                        <tr>
                            <th class="ps-4 py-3">Detail Informasi Buku</th>
                            <th class="py-3">Penulis</th>
                            <th class="py-3">Penerbit</th>
                            <th class="py-3 text-center">Status Stok</th>
                            <th class="pe-4 py-3 text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($books as $book)
                        <tr class="transition-all">
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="shadow-sm rounded overflow-hidden border bg-light d-flex align-items-center justify-content-center" style="width: 36px; height: 48px; min-width: 36px;">
                                        <img src="{{ $book->cover_url }}" alt="Cover" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                    <div>
                                        <span class="fw-bold text-dark d-block mb-0.5" style="font-size: 0.95rem;">{{ $book->judul }}</span>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="text-muted small text-uppercase" style="font-size: 0.68rem; font-weight:600;">ID: #{{ str_pad($book->id, 4, '0', STR_PAD_LEFT) }}</span>
                                            @if($book->kategori)
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-1 px-1.5" style="font-size: 0.65rem;">{{ $book->kategori }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="text-secondary fw-medium" style="font-size: 0.88rem;">{{ $book->penulis ?? '-' }}</span></td>
                            <td><span class="text-muted" style="font-size: 0.88rem;">{{ $book->penerbit ?? '-' }}</span></td>
                            <td class="text-center">
                                @if($book->stok > 0)
                                    <span class="badge bg-success-subtle text-success border border-success border-opacity-25 rounded-pill px-2.5 py-1">Tersedia ({{ $book->stok }})</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger border-opacity-25 rounded-pill px-2.5 py-1">Kosong</span>
                                @endif
                            </td>
                            <td class="pe-4 text-end">
                                <div class="d-flex justify-content-end gap-2">

                                    <form action="{{ route('digitallibrary.siswa.wishlist.destroy', $book->id) }}" method="POST" class="wishlist-remove-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm rounded-pill" title="Keluarkan dari wishlist">
                                            <i class="bi bi-heart-fill"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">
                                <i class="bi bi-heart fs-2 opacity-25 d-block mb-2"></i>
                                Belum ada buku di wishlist kamu.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-between align-items-center py-3 px-4 border-top border-light bg-light bg-opacity-25">
                    <small class="text-muted fw-medium">
                        Menampilkan {{ $books->firstItem() ?? 0 }}–{{ $books->lastItem() ?? 0 }} dari {{ $books->total() }} buku
                    </small>
                    {{ $books->appends(request()->input())->links('pagination::bootstrap-5') }}
                </div>
            </div>

            <div class="d-lg-none p-3 bg-light bg-opacity-25">
                <div class="row g-3">
                    @forelse($books as $book)
                        <div class="col-12">
                            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-start gap-3">

                                        <div class="shadow-sm rounded border bg-light overflow-hidden d-flex align-items-center justify-content-center" style="width: 55px; height: 75px; min-width: 55px;">
                                            <img src="{{ $book->cover_url }}" alt="Cover" style="width: 100%; height: 100%; object-fit: cover;">
                                        </div>

                                        <div class="overflow-hidden flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-start gap-1">
                                                <span class="fw-bold text-dark text-truncate d-block mb-0.5" style="font-size: 0.93rem; max-width: 85%;">{{ $book->judul }}</span>
                                                @if($book->kategori)
                                                    <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-1 px-1.5 py-0.5 text-xs" style="font-size: 0.62rem; font-weight: 500;">{{ $book->kategori }}</span>
                                                @endif
                                            </div>
                                            <span class="text-muted d-block text-truncate" style="font-size: 0.78rem;">
                                                <i class="bi bi-person me-1"></i> {{ $book->penulis ?? 'Tanpa Penulis' }}
                                            </span>
                                            <span class="text-muted d-block text-truncate" style="font-size: 0.72rem; margin-top: 2px;">
                                                <i class="bi bi-building me-1"></i> {{ $book->penerbit ?? '-' }}
                                            </span>
                                        </div>
                                    </div>

                                    <hr class="my-2.5 mobile-dash-line">

                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="text-muted small d-block" style="font-size: 0.65rem; color: #999 !important; font-weight: 600; letter-spacing: 0.02em;">SISA STOK</span>
                                            <span class="fw-bold {{ $book->stok > 0 ? 'text-success' : 'text-danger' }}" style="font-size: 0.85rem;">
                                                {{ $book->stok > 0 ? $book->stok . ' Eksemplar' : 'Stok Habis' }}
                                            </span>
                                        </div>

                                        <div class="d-flex gap-2">

                                            <form action="{{ route('digitallibrary.siswa.wishlist.destroy', $book->id) }}" method="POST" class="wishlist-remove-form">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm rounded-pill" title="Keluarkan dari wishlist">
                                                    <i class="bi bi-heart-fill"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="text-center text-muted py-5 card border-0 rounded-4">
                                <i class="bi bi-heart fs-1 opacity-25 mb-2"></i>
                                <p class="mb-0 small">Belum ada buku di wishlist kamu.</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="d-flex flex-column align-items-center gap-1 mt-3 pb-2">
                    <small class="text-muted mb-1" style="font-size: 0.75rem;">
                        Menampilkan {{ $books->firstItem() ?? 0 }}–{{ $books->lastItem() ?? 0 }} dari {{ $books->total() }} buku
                    </small>
                    {{ $books->appends(request()->input())->links('pagination::bootstrap-5') }}
                </div>
            </div>

        </div>
    </div>
</div>

<form id="formKirimPinjam" method="POST" action="" style="display: none;">
    @csrf
    <input type="hidden" id="submit_tanggal_pinjam" name="tanggal_pinjam">
    <input type="hidden" id="submit_tanggal_kembali" name="tanggal_kembali">
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('siswa/peminjaman.js') }}?v={{ time() }}"></script>

<script>
    function filterByKategori(kategori) {
        document.getElementById('filterKategoriInput').value = kategori;
        document.getElementById('searchFilterForm').submit();
    }

    // Konfirmasi sebelum keluar dari wishlist (pakai SweetAlert2 yang sudah dimuat di atas)
    document.querySelectorAll('.wishlist-remove-form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Keluarkan dari Wishlist?',
                text: 'Buku ini akan dihapus dari daftar wishlist kamu.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Keluarkan',
                cancelButtonText: 'Batal'
            }).then(function (result) {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session('success') }}',
            timer: 2000,
            showConfirmButton: false
        });
    @endif
</script>
@endsection