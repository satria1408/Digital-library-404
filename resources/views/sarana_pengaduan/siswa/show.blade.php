@extends('layout.dashboard-siswa')

@section('content')
<div class="container py-3 py-md-4">
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('saranapengaduan.siswa.index') }}" class="btn btn-outline-secondary btn-sm rounded-circle p-0 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px;">
            <i class="bi bi-arrow-left fs-5"></i>
        </a>
        <div>
            <h4 class="fw-bold text-dark mb-0" style="font-size: calc(1.2rem + 0.3vw);">Detail Laporan Pengaduan</h4>
            <p class="text-muted small mb-0 d-none d-sm-block">Informasi lengkap mengenai status penanganan laporan Anda.</p>
        </div>
    </div>

    <div class="row g-3 g-md-4">
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-3 p-sm-4 mb-3 mb-lg-4 bg-white">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start gap-2 border-bottom border-light pb-3 mb-3">
                    <div>
                        <span class="text-muted small d-block mb-1" style="font-size: 0.75rem;">Kode Tiket</span>
                        <h5 class="fw-bold text-primary font-monospace mb-0">{{ $complaint->ticket_code ?? 'SCH-OR4NUD' }}</h5>
                    </div>
                    <div class="w-100 w-sm-auto text-sm-end">
                        <span class="text-muted small d-block text-start text-sm-end mb-1" style="font-size: 0.75rem;">Status Penanganan</span>
                        @if(($complaint->status ?? 'diterima') == 'diterima')
                            <span class="badge bg-warning-subtle text-warning border border-warning border-opacity-50 px-3 py-2 rounded-pill fw-bold w-100 w-sm-auto text-center" style="font-size: 0.8rem;">
                                <i class="bi bi-clock-history me-1"></i> DITERIMA
                            </span>
                        @elseif($complaint->status == 'diproses')
                            <span class="badge bg-info-subtle text-info border border-info border-opacity-50 px-3 py-2 rounded-pill fw-bold w-100 w-sm-auto text-center" style="font-size: 0.8rem;">
                                <i class="bi bi-arrow-repeat me-1"></i> DIPROSES
                            </span>
                        @else
                            <span class="badge bg-success-subtle text-success border border-success border-opacity-50 px-3 py-2 rounded-pill fw-bold w-100 w-sm-auto text-center" style="font-size: 0.8rem;">
                                <i class="bi bi-check2-circle me-1"></i> SELESAI
                            </span>
                        @endif
                    </div>
                </div>

                <div class="mb-4">
                    <h5 class="fw-bold text-dark mb-2.5" style="font-size: calc(1rem + 0.2vw);">{{ $complaint->title ?? 'Pengaduan Sarana Sekolah' }}</h5>
                    <div class="text-secondary p-3 bg-light bg-opacity-50 rounded-3" style="line-height: 1.6; white-space: pre-line; font-size: 0.92rem;">
                        {{ $complaint->description }}
                    </div>
                </div>

                @if(!empty($complaint->attachment))
                    <div class="border-top border-light pt-3">
                        <span class="text-muted small d-block mb-2 fw-medium"><i class="bi bi-paperclip me-1"></i> Lampiran Dokumen / Foto:</span>
                        
                        @php
                            $extension = pathinfo($complaint->attachment, PATHINFO_EXTENSION);
                            $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                        @endphp

                        @if($isImage)
                            <div class="position-relative overflow-hidden rounded-3 border bg-light mb-2 style-preview" style="max-width: 350px;">
                                <img src="{{ asset('storage/' . $complaint->attachment) }}" class="img-fluid w-100 h-auto d-block" alt="Lampiran Pengaduan">
                            </div>
                        @endif

                        <a href="{{ asset('storage/' . $complaint->attachment) }}" target="_blank" class="btn btn-sm btn-light border rounded-3 d-inline-flex align-items-center gap-2 px-3 py-2 text-secondary shadow-xs mt-1 w-100 w-sm-auto justify-content-center">
                            <i class="bi bi-box-arrow-up-right text-primary"></i>
                            <span class="fw-semibold small">Buka Lampiran Ukuran Penuh</span>
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-3.5 mb-3 mb-md-4 bg-white">
                <h6 class="fw-bold text-dark mb-3" style="font-size: 0.9rem;"><i class="bi bi-info-circle me-2 text-primary"></i> Informasi Log Informasi</h6>
                <div class="d-flex flex-column gap-2.5">
                    <div class="d-flex justify-content-between align-items-center border-bottom border-light pb-2">
                        <span class="text-muted small">Dikirim Oleh</span>
                        <span class="fw-semibold text-dark small text-truncate ms-2" style="max-width: 180px;">{{ auth()->user()->nama_lengkap ?? auth()->user()->username }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Tanggal Masuk</span>
                        <span class="fw-semibold text-dark small text-end">
                            {{ $complaint->created_at ? $complaint->created_at->isoFormat('D MMMM Y, HH:mm') . ' WIB' : '-' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 p-4" style="background: linear-gradient(135deg, #ffffff, #fdfbf7); border-left: 4px solid #ffc107!important;">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size: 0.9rem;">
                    <i class="bi bi-chat-square-text-fill text-warning"></i> Tanggapan Pengelola
                </h6>
                
                @if(!empty($complaint->admin_notes))
                    <div class="p-3 bg-white rounded-3 border border-warning border-opacity-25 shadow-xs mb-1">
                        <p class="text-secondary small mb-2" style="line-height: 1.5; white-space: pre-line; font-size: 0.88rem;">
                            {{ $complaint->admin_notes }}
                        </p>
                        <hr class="my-2 opacity-5">
                        <div class="d-flex flex-wrap justify-content-between align-items-center text-muted gap-1" style="font-size: 0.72rem;">
                            <span><i class="bi bi-person-badge-fill me-1"></i> Tim Sarpras Sekolah</span>
                            <span>{{ $complaint->updated_at ? $complaint->updated_at->isoFormat('D MMM Y') : '' }}</span>
                        </div>
                    </div>
                @else
                    <div class="text-center py-4 text-muted border border-dashed rounded-3 bg-white px-2">
                        <i class="bi bi-chat-left-dots text-opacity-25 display-6 d-block mb-2 text-secondary"></i>
                        <span class="small fw-medium d-block lh-sm" style="font-size: 0.8rem;">Belum ada respon tanggapan resmi dari pihak sarpras sekolah.</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection