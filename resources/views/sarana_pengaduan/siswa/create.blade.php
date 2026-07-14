@extends('layout.dashboard-siswa')

@section('content')
<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8 col-xl-7">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                <div class="card-header bg-white border-bottom border-light px-3 px-md-4 py-3">
                    <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-start align-items-md-center gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-2.5 rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center flex-shrink-0" style="width: 42px; height: 42px;">
                                <i class="bi bi-megaphone-fill fs-5"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold text-dark" style="font-size: 1.05rem;">Buat Laporan Pengaduan</h5>
                                <p class="text-muted small mb-0 d-none d-md-block mt-0.5">Laporkan keluhan fasilitas sekolah secara cepat dan jelas.</p>
                            </div>
                        </div>
                        <a href="{{ route('siswa.complaints.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 fw-medium">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body p-3 p-md-4">
                    <form id="formPengaduan" action="{{ route('siswa.complaints.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Judul Pengaduan</label>
                            <input type="text" id="judulInput" name="judul"
                                   class="form-control @error('judul') is-invalid @enderror"
                                   placeholder="Contoh: AC Kelas XI-RPL Tidak Dingin"
                                   value="{{ old('judul') }}" maxlength="100" required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="form-label fw-semibold mb-0">Isi Laporan / Detail Kerusakan</label>
                                <span class="text-muted small" id="charCounter"><span id="currentChars">0</span>/1000</span>
                            </div>
                            <textarea id="isiInput" name="isi_laporan" rows="6"
                                      class="form-control @error('isi_laporan') is-invalid @enderror"
                                      placeholder="Tuliskan lokasi spesifik, nomor inventaris jika ada, dan kronologi kejadian..."
                                      maxlength="1000" required>{{ old('isi_laporan') }}</textarea>
                            @error('isi_laporan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-sm-flex justify-content-sm-between">
                            <button type="submit" id="btnSubmit" class="btn btn-primary rounded-pill px-4 shadow-sm d-flex align-items-center justify-content-center gap-2 order-sm-2">
                                <i class="bi bi-send-fill" id="iconSubmit"></i>
                                <span id="textSubmit">Kirim Laporan</span>
                            </button>
                            <a href="{{ route('siswa.complaints.index') }}" class="btn btn-light rounded-pill px-4 order-sm-1">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("formPengaduan");
        const isiInput = document.getElementById("isiInput");
        const currentChars = document.getElementById("currentChars");
        const charCounter = document.getElementById("charCounter");
        const btnSubmit = document.getElementById("btnSubmit");
        const textSubmit = document.getElementById("textSubmit");
        const iconSubmit = document.getElementById("iconSubmit");

        function updateCounter() {
            const length = isiInput.value.length;
            currentChars.textContent = length;
            charCounter.classList.toggle("text-danger", length >= 900);
            charCounter.classList.toggle("fw-semibold", length >= 900);
        }
        isiInput.addEventListener("input", updateCounter);
        updateCounter();

        form.addEventListener("submit", function (e) {
            if (btnSubmit.disabled) {
                e.preventDefault();
                return;
            }
            btnSubmit.disabled = true;
            textSubmit.textContent = "Mengirim...";
            iconSubmit.className = "spinner-border spinner-border-sm";
        });
    });
</script>
@endsection