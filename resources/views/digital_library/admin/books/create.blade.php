@extends('layout.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Tambah Buku Baru</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('digitallibrary.admin.books.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">ISBN</label>
                        <input type="text" name="isbn" class="form-control @error('isbn') is-invalid @enderror" value="{{ old('isbn') }}" placeholder="Contoh: 9786020633178" required>
                        @error('isbn')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Judul Buku</label>
                        <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') }}" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Penulis</label>
                            <input type="text" name="penulis" class="form-control @error('penulis') is-invalid @enderror" value="{{ old('penulis') }}" required>
                            @error('penulis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Penerbit</label>
                            <input type="text" name="penerbit" class="form-control @error('penerbit') is-invalid @enderror" value="{{ old('penerbit') }}" required>
                            @error('penerbit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kategori</label>
                            <input type="text" name="kategori" class="form-control @error('kategori') is-invalid @enderror" value="{{ old('kategori') }}" placeholder="Contoh: Novel, Teknologi, Sains" required>
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stok</label>
                            <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok') }}" min="0" required>
                            @error('stok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 p-3 bg-light rounded-3 border">
                        <label class="form-label fw-semibold text-secondary">Cover Buku</label>

                        <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-3">
                            <div class="shadow-sm rounded overflow-hidden border bg-white d-flex align-items-center justify-content-center" style="width: 70px; height: 100px; min-width: 70px;">
                                <img id="coverPreview" src="https://images.unsplash.com/photo-1543002588-bfa74002ed7e?q=80&w=400" alt="Preview Cover" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>

                            <div class="w-100">
                                <!-- PENTING: name harus "cover_url" biar match sama BookController@store -->
                                <input type="file" name="cover_url" id="coverInput" class="form-control @error('cover_url') is-invalid @enderror" accept="image/*">
                                <div class="form-text text-muted" style="font-size: 0.78rem;">
                                    *Format: JPG, JPEG, PNG, WEBP (Max: 2MB). Boleh dikosongkan jika belum ada cover.
                                </div>
                                @error('cover_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('digitallibrary.admin.books.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-success">Simpan Buku</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('coverInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('coverPreview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection