@extends('layout.siswa_pengaduan')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* Sinkronisasi dengan layout utama */
    .content-container {
        padding-top: 1rem;
        padding-bottom: 2rem;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Kartu Form Bergaya Modern Minimalis */
    .card-form-custom {
        background: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
    }

    /* Modifikasi Form Control & Select */
    .input-custom {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.65rem 0.9rem;
        font-size: 0.95rem;
        color: #334155;
        transition: all 0.2s ease;
    }

    .input-custom:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
        background-color: #ffffff;
    }

    /* Tombol Kembali Kustom Bulat */
    .btn-back-custom {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        transition: all 0.2s ease;
    }

    .btn-back-custom:hover {
        color: #0d6efd;
        background-color: rgba(13, 110, 253, 0.05);
        border-color: rgba(13, 110, 253, 0.2);
    }

    /* Container Khusus Switch Anonim */
    .switch-panel {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1rem;
    }

    /* Animasi Masuk Field Kustom */
    .fade-down-element {
        animation: fadeDown 0.2s ease-out forwards;
    }

    @keyframes fadeDown {
        from { opacity: 0; transform: translateY(-8px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="container content-container">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card card-form-custom p-2 p-md-3">
                
                <div class="card-header bg-transparent border-0 px-3 pt-3 pb-2">
                    <div class="d-flex align-items-center gap-3">
                        <a href="{{ route('saranapengaduan.siswa.index') }}" class="btn btn-back-custom rounded-circle shadow-sm" title="Kembali ke Dashboard">
                            <i class="bi bi-arrow-left fs-5"></i>
                        </a>
                        <div>
                            <h5 class="fw-bold text-dark mb-1">Buat Laporan Baru</h5>
                            <p class="text-muted small mb-0">Silakan isi detail fasilitas sekolah yang memerlukan perbaikan.</p>
                        </div>
                    </div>
                </div>

                <div class="card-body px-3 pt-3">
                    <form id="formPengaduan" action="{{ route('saranapengaduan.siswa.store') }}" method="POST">
                        @csrf

                        <div class="mb-3.5">
                            <label class="form-label fw-semibold text-secondary small">Jenis Kendala Sarpras</label>
                            <select id="selectKategori" class="form-select input-custom" required>
                                <option value="" disabled selected>-- Pilih Jenis Fasilitas --</option>
                                <option value="Kerusakan AC / Kipas Angin Kelas">Kerusakan AC / Kipas Angin Kelas</option>
                                <option value="Fasilitas Kamar Mandi Rusak / Air Macet">Fasilitas Kamar Mandi Rusak / Air Macet</option>
                                <option value="Meja / Kursi Belajar Rusak">Meja / Kursi Belajar Rusak</option>
                                <option value="Koneksi Wi-Fi Sekolah Lambat / Putus">Koneksi Wi-Fi Sekolah Lambat / Putus</option>
                                <option value="lainnya">Lainnya (Ketik Manual...)</option>
                            </select>
                        </div>

                        <div class="mb-3.5 d-none" id="boxJudulManual">
                            <label class="form-label fw-semibold text-primary small">Tulis Masalah Secara Spesifik</label>
                            <input type="text" id="judulInput" name="judul"
                                   class="form-control input-custom @error('judul') is-invalid @enderror"
                                   placeholder="Contoh: Lampu ruang kelas berkedip terus"
                                   value="{{ old('judul') }}" maxlength="100">
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="form-label fw-semibold text-secondary small mb-0">Rincian Deskripsi Kerusakan</label>
                                <span class="text-muted small" id="charCounter" style="font-size: 0.8rem;"><span id="currentChars">0</span>/1000</span>
                            </div>
                            <textarea id="isiInput" name="isi_laporan" rows="5"
                                      class="form-control input-custom @error('isi_laporan') is-invalid @enderror"
                                      placeholder="Sebutkan lokasi ruangan/lantai, nomor kode meja/kursi jika ada, serta kendala nyata yang dialami..."
                                      maxlength="1000" required>{{ old('isi_laporan') }}</textarea>
                            @error('isi_laporan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4 switch-panel d-flex align-items-center justify-content-between">
                            <div>
                                <label class="fw-semibold mb-0 d-block text-dark small" style="cursor: pointer;" for="isAnonymous">Kirim Tanpa Nama (Anonim)</label>
                                <span class="text-muted" style="font-size: 11px;">Identitas asli kamu disembunyikan dari rekam jejak publik</span>
                            </div>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input fs-5 m-0" type="checkbox" role="switch" id="isAnonymous" name="is_anonymous" value="1" style="cursor: pointer;">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 border-top pt-3">
                            <a href="{{ route('saranapengaduan.siswa.index') }}" class="btn btn-light rounded-pill px-4 btn-sm fw-medium text-secondary">Batal</a>
                            <button type="submit" id="btnSubmit" class="btn btn-primary rounded-pill px-4 btn-sm fw-semibold shadow-sm d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-send-fill" id="iconSubmit"></i>
                                <span id="textSubmit">Kirim Aduan</span>
                            </button>
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
        const selectKategori = document.getElementById("selectKategori");
        const boxJudulManual = document.getElementById("boxJudulManual");
        const judulInput = document.getElementById("judulInput");
        const isiInput = document.getElementById("isiInput");
        const currentChars = document.getElementById("currentChars");
        const charCounter = document.getElementById("charCounter");
        const btnSubmit = document.getElementById("btnSubmit");

        // 1. Sinkronisasi Dropdown & Kolom Judul Kustom
        selectKategori.addEventListener("change", function () {
            if (this.value === "lainnya") {
                boxJudulManual.classList.remove("d-none");
                boxJudulManual.classList.add("fade-down-element");
                judulInput.setAttribute("required", "required");
                judulInput.value = "";
                judulInput.focus();
            } else {
                boxJudulManual.classList.add("d-none");
                boxJudulManual.classList.remove("fade-down-element");
                judulInput.removeAttribute("required");
                judulInput.value = this.value; 
            }
        });

        // 2. Penghitung Karakter Input Deskripsi
        function updateCounter() {
            const length = isiInput.value.length;
            currentChars.textContent = length;
            charCounter.classList.toggle("text-danger", length >= 900);
            charCounter.classList.toggle("fw-bold", length >= 900);
        }
        isiInput.addEventListener("input", updateCounter);
        updateCounter();

        // 3. Request Handler AJAX + SweetAlert2
        form.addEventListener("submit", function (e) {
            e.preventDefault();

            if (btnSubmit.disabled) return;
            btnSubmit.disabled = true;

            Swal.fire({
                title: 'Sedang Mengirim Laporan',
                text: 'Mohon tunggu, sistem sedang memvalidasi data...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) throw new Error('Terjadi kegagalan komunikasi dengan server.');
                return response.json();
            })
            .then(data => {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil Dikirim',
                    text: 'Laporan kerusakan sarana telah berhasil dicatat oleh sistem.',
                    confirmButtonText: 'Buka Riwayat Laporan',
                    confirmButtonColor: '#0d6efd',
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.replace("{{ route('saranapengaduan.siswa.index') }}");
                    }
                });
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Mengirim',
                    text: error.message || 'Periksa koneksi internet Anda lalu coba kembali.',
                    confirmButtonColor: '#64748b'
                });
                btnSubmit.disabled = false;
            });
        });
    });
</script>
@endsection