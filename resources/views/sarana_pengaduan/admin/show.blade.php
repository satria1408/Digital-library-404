@extends('layout.app') 

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('admin.complaints.index') }}" class="text-decoration-none small fw-bold text-muted">
                ← Kembali ke Daftar Laporan
            </a>
            <h2 class="h4 mb-0 mt-1 text-gray-800 fw-bold">Detail Pengaduan #{{ $complaint->ticket_code }}</h2>
        </div>
        <div>
            @if($complaint->status == 'diterima')
                <span class="badge bg-danger px-3 py-2 text-uppercase fs-8">Status: Diterima</span>
            @elseif($complaint->status == 'diproses')
                <span class="badge bg-warning text-dark px-3 py-2 text-uppercase fs-8">Status: Diproses</span>
            @else
                <span class="badge bg-success px-3 py-2 text-uppercase fs-8">Status: Selesai</span>
            @endif
        </div>
    </div>

    @if(session('info'))
        <div class="alert alert-info border-0 shadow-sm alert-dismissible fade show" role="alert">
            {{ session('info') }}
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold text-dark mb-3">Informasi Laporan</h5>
                    
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label class="text-muted small d-block">Pelapor</label>
                            @if($complaint->is_anonymous)
                                <span class="fw-semibold text-secondary">Anonim (Identitas Dirahasiakan)</span>
                            @else
                                <span class="fw-semibold text-dark">{{ $complaint->user->name }}</span>
                            @endif
                        </div>
                        <div class="col-sm-6">
                            <label class="text-muted small d-block">Tanggal Masuk</label>
                            <span class="fw-semibold text-dark">{{ $complaint->created_at->translatedFormat('d F Y, H:i') }}</span>
                        </div>
                        <div class="col-sm-6">
                            <label class="text-muted small d-block">Jenis Pengaduan</label>
                            <span class="badge {{ $complaint->type == 'kerusakan' ? 'bg-danger-subtle text-danger' : 'bg-warning-subtle text-warning' }} text-capitalize">
                                {{ $complaint->type }}
                            </span>
                        </div>
                        <div class="col-sm-6">
                            <label class="text-muted small d-block">Kategori Fasilitas / Layanan</label>
                            <span class="fw-semibold text-dark">{{ $complaint->category }}</span>
                        </div>
                        <div class="col-12">
                            <label class="text-muted small d-block">Deskripsi Keluhan</label>
                            <div class="p-3 bg-light rounded mt-1 text-dark" style="white-space: pre-line;">{{ $complaint->description }}</div>
                        </div>

                        @if($complaint->type == 'kerusakan' || $complaint->photo_path)
                        <div class="col-12 mt-3">
                            <label class="text-muted small d-block mb-1">Bukti Foto Kerusakan</label>
                            @if($complaint->photo_path)
                                <div class="overflow-hidden rounded border" style="max-width: 400px;">
                                    <img src="{{ asset('storage/' . $complaint->photo_path) }}" class="img-fluid d-block" alt="Bukti Kerusakan">
                                </div>
                            @else
                                <span class="text-danger small d-block border border-danger border-dashed p-2 rounded">
                                     Peringatan: Tidak ada lampiran foto kerusakan dari pelapor.
                                </span>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title fw-bold text-dark mb-3">Riwayat Transparansi Kerja (Audit Log)</h5>
                    <div class="position-relative ps-2">
                        @forelse($complaint->logs as $log)
                            <div class="mb-3 border-start border-2 ps-3 pb-2 position-relative">
                                <span class="position-absolute start-0 translate-middle-x bg-primary rounded-circle" style="width: 10px; height: 10px; margin-left: -1px; top: 6px;"></span>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold small text-dark">
                                        Status diubah dari <span class="text-capitalize text-danger">{{ $log->status_from }}</span> ke <span class="text-capitalize text-success">{{ $log->status_to }}</span>
                                    </span>
                                    <span class="text-muted fs-8">{{ $log->created_at->translatedFormat('d M Y, H:i') }}</span>
                                </div>
                                <p class="text-muted small mb-1">Eksekutor: <strong class="text-dark">{{ $log->admin->name }}</strong></p>
                                <p class="small text-secondary bg-light p-2 rounded mb-0 italic">"{{ $log->notes }}"</p>
                            </div>
                        @empty
                            <div class="text-muted small py-2 text-center">
                                Belum ada riwayat perubahan. Laporan ini masih murni baru masuk.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0 position-sticky" style="top: 20px;">
                <div class="card-body">
                    <h5 class="card-title fw-bold text-dark mb-3">Eksekusi Tindakan</h5>
                    
                    <form action="{{ route('admin.complaints.update_status', $complaint->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Ubah Status Menjadi</label>
                            <select name="status" class="form-select">
                                <option value="diterima" {{ $complaint->status == 'diterima' ? 'selected' : '' }}>Diterima (Antrean)</option>
                                <option value="diproses" {{ $complaint->status == 'diproses' ? 'selected' : '' }}>Diproses (Pengerjaan)</option>
                                <option value="selesai" {{ $complaint->status == 'selesai' ? 'selected' : '' }}>Selesai (Tuntas)</option>
                            </select>
                            @error('status')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted">Catatan & Umpan Balik untuk Siswa</label>
                            <textarea name="admin_notes" rows="5" class="form-control small" placeholder="Tulis progres perbaikan di sini... Contoh: Material sudah dipesan, perbaikan tangki air dikerjakan besok pagi oleh tim teknisi.">{{ old('admin_notes', $complaint->admin_notes) }}</textarea>
                            <div class="form-text fs-8 text-muted">Catatan ini akan langsung tampil di halaman tracking siswa agar mereka percaya sekolah sedang bekerja.</div>
                            @error('admin_notes')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary fw-bold">
                                Simpan Perubahan Status
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection