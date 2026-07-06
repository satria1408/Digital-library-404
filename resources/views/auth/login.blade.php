@extends('layout.auth')

@section('content')
<style>
.page{
    position:fixed;
    inset:0;
    width:100vw;
    height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;

    background-image:url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?auto=format&fit=crop&w=3000&q=100');
    background-size:cover;
    background-position:center center;
    background-repeat:no-repeat;
}

.page::before{
    content:'';
    position:absolute;
    inset:0;
    background:rgba(0,0,0,.45);
}

.glass-card{
    position:relative;
    z-index:1;
    width:100%;
    max-width:360px;
    background:rgba(255,255,255,.08);
    border:1px solid rgba(255,255,255,.15);
    border-radius:14px;
    backdrop-filter:blur(14px);
    overflow:hidden;
}

.card-header-custom{
    padding:28px 32px 24px;
    text-align:center;
    border-bottom:1px solid rgba(255,255,255,.1);
}

.card-header-custom h1{
    color:#fff;
    font-size:20px;
    margin-bottom:5px;
}

.card-header-custom p{
    color:rgba(255,255,255,.7);
    font-size:13px;
    margin:0;
}

.form-label{
    color:rgba(255,255,255,.65);
    font-size:12px;
    text-transform:uppercase;
    letter-spacing:.05em;
}

.form-control{
    background:rgba(255,255,255,.08)!important;
    border:1px solid rgba(255,255,255,.2)!important;
    color:#fff!important;
    border-radius:8px;
}

.form-control::placeholder{
    color:rgba(255,255,255,.35)!important;
}

.form-control:focus{
    border-color:rgba(100,180,255,.7)!important;
    box-shadow:0 0 0 .2rem rgba(100,180,255,.15)!important;
}

.divider-line{
    border-color:rgba(255,255,255,.15);
}

.divider-text{
    color:rgba(255,255,255,.4);
    font-size:12px;
}

.btn-daftar{
    color:rgba(255,255,255,.8);
    border-color:rgba(255,255,255,.2);
}

.btn-daftar:hover{
    background:rgba(255,255,255,.08);
    color:#fff;
    border-color:rgba(255,255,255,.4);
}

.alert-danger{
    background:rgba(220,53,69,.15);
    border:1px solid rgba(220,53,69,.3);
    color:#fff;
}

/* Floating Action Button (FAB) */
.fab-container {
    position: fixed;
    bottom: 25px;
    right: 25px;
    z-index: 1050;
}

.btn-fab {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.25);
    backdrop-filter: blur(10px);
    color: #fff;
    font-size: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    transition: all 0.3s ease;
}

.btn-fab:hover {
    background: rgba(100, 180, 255, 0.3);
    border-color: rgba(100, 180, 255, 0.5);
    color: #fff;
    transform: scale(1.08);
}

/* Glassmorphism khusus untuk isi Modal Bootstrap */
.modal-glass {
    background: rgba(30, 30, 35, 0.85) !important;
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.15) !important;
    color: #fff;
}

.modal-glass .modal-header {
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.modal-glass .modal-footer {
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.modal-glass .btn-close {
    filter: invert(1);
}
</style>

<div class="page">
    <div class="glass-card">

        <div class="card-header-custom">
            <h1>Login Perpustakaan</h1>
            <p>Masukkan akun Anda untuk melanjutkan</p>
        </div>

        <div class="p-4">

            @if ($errors->any())
                <div class="alert alert-danger py-2">
                    {{ $errors->first() }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success py-2">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('login.process') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input
                        type="text"
                        name="username"
                        class="form-control"
                        placeholder="Masukkan username"
                        value="{{ old('username') }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="Masukkan password"
                        required
                    >
                </div>

                <div class="text-end mb-3">
                    <a href="#"
                       class="text-decoration-none"
                       style="font-size:12px;color:rgba(100,180,255,.85);">
                        Lupa Password?
                    </a>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    Masuk
                </button>
            </form>

            <div class="d-flex align-items-center my-3">
                <hr class="divider-line flex-grow-1">
                <span class="divider-text px-2">atau</span>
                <hr class="divider-line flex-grow-1">
            </div>

            <a href="{{ route('register') }}"
               class="btn btn-outline-secondary w-100 btn-daftar">
                Daftar Anggota
            </a>

        </div>

    </div>
</div>

<!-- FLOATING ACTION BUTTON (KOTAK SARAN) -->
<div class="fab-container">
    <button type="button" class="btn btn-fab" data-bs-toggle="modal" data-bs-target="#suggestionHubModal" title="Kotak Saran & Keluhan">
        <i class="bi bi-chat-left-text-fill"></i>
    </button>
</div>

<!-- MODAL INDUK UTAMA (PILIHAN KIRIM ATAU CEK STATUS) -->
<div class="modal fade" id="suggestionHubModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-glass">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="bi bi-laptop"></i> Layanan Pengaduan Sistem</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <p class="text-muted-light small mb-4">Punya kendala eror di aplikasi perpustakaan atau saran untuk developer? Silakan pilih menu di bawah ini.</p>
                <div class="row g-3">
                    <div class="col-6">
                        <button class="btn btn-outline-primary w-100 py-3 fw-bold" data-bs-target="#createSuggestionModal" data-bs-toggle="modal">
                            <i class="bi bi-pencil-square d-block fs-3 mb-2"></i> Kirim Masukan
                        </button>
                    </div>
                    <div class="col-6">
                        <button class="btn btn-outline-success w-100 py-3 fw-bold" data-bs-target="#checkTicketModal" data-bs-toggle="modal">
                            <i class="bi bi-ticket-perforated d-block fs-3 mb-2"></i> Cek Status Tiket
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL FORM 1: KIRIM MASUKAN -->
<div class="modal fade" id="createSuggestionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-glass">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square"></i> Tulis Keluhan / Saran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formKirimSaran" action="{{ route('saran.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div id="alertSaran" class="alert d-none py-2" style="font-size:13px;"></div>
                    
                    <div class="mb-3">
                        <label class="form-label text-white">Subjek Masukan</label>
                        <input type="text" name="subjek" class="form-control" placeholder="Contoh: Eror saat klik pinjam" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white">Detail Keluhan / Saran</label>
                        <textarea name="isi_saran" class="form-control" rows="4" placeholder="Tulis rincian kendala yang lo alami secara detail..." required></textarea>
                    </div>
                    <span class="text-muted d-block" style="font-size:11px; color:rgba(255,255,255,.5) !important;">
                        *Pesan ini dikirim anonim jika lo belum masuk ke akun.
                    </span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-outline-secondary text-white border-secondary" data-bs-target="#suggestionHubModal" data-bs-toggle="modal">Kembali</button>
                    <button type="submit" id="btnSubmitSaran" class="btn btn-sm btn-primary px-3">Kirim Sekarang</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL FORM 2: CEK STATUS TIKET -->
<div class="modal fade" id="checkTicketModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-glass">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="bi bi-search"></i> Lacak Status Balasan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formCekTiket" action="{{ route('saran.check') }}" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="ticket_code" id="ticket_code_input" class="form-control" placeholder="Masukkan Kode Tiket (Contoh: DEV-XXXXXX)" required>
                        <button class="btn btn-success" type="submit" id="btnCekTiket"><i class="bi bi-search"></i> Cek</button>
                    </div>
                </form>

                <!-- Container Hasil Pencarian Tiket -->
                <div id="hasilCekTiket" class="d-none mt-3 p-3 rounded" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="fw-bold mb-0 text-info" id="resSubjek"></h6>
                        <span class="badge" id="resStatus"></span>
                    </div>
                    <p class="small text-muted mb-1" style="font-size:11px;" id="resTanggal"></p>
                    <div class="p-2 mb-3 rounded text-white-50 small" style="background:rgba(0,0,0,0.2);" id="resIsi"></div>
                    
                    <div class="p-2 rounded small border border-primary" style="background:rgba(100,180,255,0.05);">
                        <label class="fw-bold text-primary mb-1 d-block"><i class="bi bi-reply-fill"></i> Respon Developer:</label>
                        <p class="mb-0 text-white" id="resBalasan" style="white-space: pre-line;"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-secondary text-white border-secondary" data-bs-target="#suggestionHubModal" data-bs-toggle="modal">Kembali</button>
            </div>
        </div>
    </div>
</div>

<script>
  // Script Bawaan Login Lo
  document.querySelector('form').addEventListener('submit', function () {
    const btn = this.querySelector('button[type="submit"]');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';
  });

  // AJAX Prosedur Kirim Saran
  document.getElementById('formKirimSaran').addEventListener('submit', function(e) {
      e.preventDefault();
      const btn = document.getElementById('btnSubmitSaran');
      const alertBox = document.getElementById('alertSaran');
      
      btn.disabled = true;
      btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mengirim...';

      fetch(this.action, {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': this.querySelector('input[name="_token"]').value
          },
          body: JSON.stringify({
              subjek: this.querySelector('input[name="subjek"]').value,
              isi_saran: this.querySelector('textarea[name="isi_saran"]').value,
          })
      })
      .then(res => res.json())
      .then(data => {
          alertBox.classList.remove('d-none', 'alert-danger', 'alert-success');
          if(data.success) {
              alertBox.classList.add('alert-success');
              alertBox.innerHTML = `<strong>Sukses!</strong> ${data.message}<br><br>Gunakan kode tiket ini untuk melacak balasan:<br><strong class="fs-5 text-warning font-monospace d-block text-center mt-1">${data.ticket_code}</strong><br><small>*Salin kode ini sekarang.</small>`;
              this.reset();
          } else {
              alertBox.classList.add('alert-danger');
              alertBox.innerText = data.message;
          }
      })
      .catch(() => {
          alertBox.classList.remove('d-none', 'alert-success');
          alertBox.classList.add('alert-danger');
          alertBox.innerText = 'Terjadi kesalahan sistem, coba lagi nanti.';
      })
      .finally(() => {
          btn.disabled = false;
          btn.innerText = 'Kirim Sekarang';
      });
  });

  // AJAX Prosedur Cek Balasan Tiket (IKON PERMANEN DI SINI)
  document.getElementById('formCekTiket').addEventListener('submit', function(e) {
      e.preventDefault();
      const btn = document.getElementById('btnCekTiket');
      const hasilBox = document.getElementById('hasilCekTiket');
      
      btn.disabled = true;
      btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
      hasilBox.classList.add('d-none');

      fetch(this.action, {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': this.querySelector('input[name="_token"]').value
          },
          body: JSON.stringify({
              ticket_code: document.getElementById('ticket_code_input').value
          })
      })
      .then(res => {
          if (!res.ok) throw res;
          return res.json();
      })
      .then(res => {
          if(res.success) {
              document.getElementById('resSubjek').innerText = res.data.subjek;
              document.getElementById('resTanggal').innerHTML = `<i class="bi bi-clock"></i> Dikirim: ${res.data.tanggal_kirim}`;
              document.getElementById('resIsi').innerText = res.data.isi_saran;
              document.getElementById('resBalasan').innerText = res.data.reply_developer;

              const badge = document.getElementById('resStatus');
              badge.className = 'badge';
              if(res.data.status === 'unread') {
                  badge.classList.add('bg-danger');
                  badge.innerText = 'Unread';
              } else if(res.data.status === 'read') {
                  badge.classList.add('bg-warning', 'text-dark');
                  badge.innerText = 'Read';
              } else {
                  badge.classList.add('bg-success');
                  badge.innerText = 'Replied';
              }

              hasilBox.classList.remove('d-none');
          }
      })
      .catch(async (err) => {
          let msg = 'Kode tiket tidak ditemukan atau salah ketik.';
          if(err.json) {
              const errData = await err.json();
              msg = errData.message;
          }
          alert(msg);
      })
      .finally(() => {
          btn.disabled = false;
          btn.innerHTML = '<i class="bi bi-search"></i> Cek';
      });
  });
</script>
@endsection