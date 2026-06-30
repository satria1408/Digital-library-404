@extends('layout.dashboard-siswa')

@section('content')
<div class="container py-3">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="bi bi-bookmark-heart-fill text-danger me-2"></i>
                Wishlist Buku
            </h4>
            <p class="text-muted mb-0">
                Daftar buku yang ingin kamu pinjam nanti.
            </p>
        </div>

        <a href="{{ route('siswa.peminjaman') }}" class="btn btn-primary rounded-pill">
            <i class="bi bi-plus-circle me-1"></i>
            Tambah Buku
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-4">
            {{ session('success') }}
        </div>
    @endif

    @if($wishlists->count())

    <div class="card border-0 shadow-sm rounded-4">
        <div class="table-responsive">
            <table class="table align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th>Buku</th>
                        <th>Penulis</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th width="220" class="text-center">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody>

                @foreach($wishlists as $wishlist)

                    <tr>

                        <td>
                            <div class="d-flex align-items-center gap-3">

                                <img src="{{ $wishlist->book->cover_url }}"
                                     width="55"
                                     class="rounded shadow-sm">

                                <div>
                                    <div class="fw-semibold">
                                        {{ $wishlist->book->judul }}
                                    </div>

                                    <small class="text-muted">
                                        ID #{{ $wishlist->book->id }}
                                    </small>
                                </div>

                            </div>
                        </td>

                        <td>
                            {{ $wishlist->book->penulis ?? '-' }}
                        </td>

                        <td>
                            <span class="badge bg-secondary">
                                {{ $wishlist->book->kategori }}
                            </span>
                        </td>

                        <td>

                            @if($wishlist->book->stok > 0)

                                <span class="badge bg-success">
                                    {{ $wishlist->book->stok }} Tersedia
                                </span>

                            @else

                                <span class="badge bg-danger">
                                    Habis
                                </span>

                            @endif

                        </td>

                        <td class="text-center">

                            @if($wishlist->book->stok > 0)

                                <a href="{{ route('siswa.peminjaman') }}"
                                   class="btn btn-success btn-sm rounded-pill">

                                    <i class="bi bi-journal-plus"></i>

                                    Pinjam

                                </a>

                            @endif

                            <form action="{{ route('wishlist.destroy',$wishlist->id) }}"
                                  method="POST"
                                  class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button
                                    class="btn btn-outline-danger btn-sm rounded-pill"
                                    onclick="return confirm('Hapus dari wishlist?')">

                                    <i class="bi bi-trash"></i>

                                </button>

                            </form>

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>
        </div>
    </div>

    @else

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body text-center py-5">

            <i class="bi bi-bookmark-heart display-1 text-secondary"></i>

            <h5 class="mt-3">
                Wishlist masih kosong
            </h5>

            <p class="text-muted">
                Tambahkan buku yang ingin kamu pinjam nanti.
            </p>

            <a href="{{ route('siswa.peminjaman') }}"
               class="btn btn-primary rounded-pill">

                Lihat Katalog Buku

            </a>

        </div>
    </div>

    @endif

</div>
@endsection