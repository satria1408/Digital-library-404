@extends('layout.auth')

@section('content')
<style>
.page { position: fixed; inset: 0; display: flex; align-items: center; justify-content: center; background-image: url('https://images.unsplash.com/photo-1521587760476-6c12a4b040da?auto=format&fit=crop&w=800&q=80'); background-size: cover; background-position: center; }
.page::before { content:''; position: absolute; inset: 0; background: rgba(255,255,255,.25); }
.glass-card { position: relative; z-index: 1; width: 100%; max-width: 360px; background: rgba(255,255,255,.45); border: 1px solid rgba(255,255,255,.4); border-radius: 14px; backdrop-filter: blur(16px); box-shadow: 0 8px 32px rgba(31,38,135,.15); }
.form-control { background: rgba(255,255,255,.6)!important; border: 1px solid rgba(0,0,0,.15)!important; border-radius: 8px; }
.fab-container { position: fixed; bottom: 25px; right: 25px; z-index: 1050; }
.btn-fab { width: 56px; height: 56px; border-radius: 50%; background: rgba(255,255,255,.7); border: 1px solid rgba(255,255,255,.5); backdrop-filter: blur(10px); font-size: 24px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(0,0,0,.1); }
.modal-glass { background: rgba(255, 255, 255, 0.95) !important; backdrop-filter: blur(20px); }
</style>

<div class="page">
    <div class="glass-card p-4">
        <h4 class="text-center fw-bold mb-4 text-dark">Login OneSchool</h4>
        
        @if ($errors->any())
            <div class="alert alert-danger py-2 small">{{ $errors->first() }}</div>
        @endif

        <form id="formLoginUtama" action="{{ route('login.process') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label small fw-bold text-uppercase">NISN / Username</label>
                <input type="text" name="login_input" class="form-control" placeholder="Username atau 10 digit NISN" required>
            </div>
            <div class="mb-3">
                <label class="form-label small fw-bold text-uppercase">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 fw-bold shadow-sm">Masuk Aplikasi</button>
        </form>
        <div class="text-center mt-3">
            <a href="{{ route('register') }}" class="btn btn-outline-primary btn-sm w-100">Daftar Anggota (Siswa)</a>
        </div>
    </div>
</div>

<div class="fab-container">
    <button type="button" class="btn btn-fab" data-bs-toggle="modal" data-bs-target="#helperHubModal">
        <i class="bi bi-chat-left-text-fill"></i>
    </button>
</div>

<div class="modal fade" id="helperHubModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-glass">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-dark"><i class="bi bi-grid-fill me-2"></i>Pusat Bantuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <div class="mb-4 p-3 rounded border border-primary border-opacity-25" style="background: rgba(37, 99, 235, 0.02);">
                    <h6 class="fw-bold text-dark mb-2"><i class="bi bi-building me-2"></i>Layanan Pengaduan Sekolah</h6>
                    <div class="row g-2">
                        <div class="col-6"><button class="btn btn-primary w-100 btn-sm fw-bold" data-bs-target="#schoolModal" data-bs-toggle="modal"><i class="bi bi-megaphone-fill me-1"></i> Lapor</button></div>
                        <div class="col-6"><button class="btn btn-outline-primary w-100 btn-sm fw-bold" data-bs-target="#schoolCheckModal" data-bs-toggle="modal"><i class="bi bi-search me-1"></i> Lacak</button></div>
                    </div>
                </div>
                <div class="p-3 rounded border border-success border-opacity-25" style="background: rgba(40, 167, 69, 0.02);">
                    <h6 class="fw-bold text-dark mb-2"><i class="bi bi-code-slash me-2"></i>Kotak Saran Developer</h6>
                    <div class="row g-2">
                        <div class="col-6"><button class="btn btn-success w-100 btn-sm fw-bold" data-bs-target="#devModal" data-bs-toggle="modal"><i class="bi bi-pencil-square me-1"></i> Kirim</button></div>
                        <div class="col-6"><button class="btn btn-outline-success w-100 btn-sm fw-bold" data-bs-target="#devCheckModal" data-bs-toggle="modal"><i class="bi bi-ticket me-1"></i> Cek Tiket</button></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="schoolModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-glass">
            <div class="modal-header"><h5 class="modal-title fw-bold text-dark">Buat Pengaduan Sekolah</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form id="formKirimPengaduanSekolah" action="{{ route('siswa.complaints.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div id="alertSchool" class="alert d-none py-2 small"></div>
                    <div class="mb-3"><label class="form-label text-dark small fw-bold">Judul Laporan</label><input type="text" id="judulPengaduan" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label text-dark small fw-bold">Isi Detail</label><textarea id="isiPengaduan" class="form-control" rows="3" required></textarea></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-sm btn-secondary" data-bs-target="#helperHubModal" data-bs-toggle="modal">Kembali</button><button type="submit" id="btnSubmitSchool" class="btn btn-sm btn-primary">Kirim Laporan</button></div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="schoolCheckModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-glass">
            <div class="modal-header"><h5 class="modal-title fw-bold text-dark">Lacak Pengaduan Sekolah</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <form id="formCekTiketSekolah" action="{{ route('siswa.complaints.check') }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <input type="text" id="schoolTicketCode" class="form-control" placeholder="Masukkan Kode Laporan" required>
                        <button class="btn btn-primary btn-sm" type="submit" id="btnCekSchool">Cek</button>
                    </div>
                </form>
                <div id="hasilCekSchool" class="d-none mt-3 p-3 rounded bg-light border text-dark small">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="fw-bold text-primary mb-0" id="resSchoolJudul"></h6>
                        <span class="badge bg-info" id="resSchoolStatus"></span>
                    </div>
                    <p class="mb-2 text-secondary" id="resSchoolIsi"></p>
                    <div class="p-2 border border-primary rounded bg-white text-primary">
                        <strong>Tanggapan Sekolah:</strong> <br><span id="resSchoolTanggapan"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-sm btn-secondary" data-bs-target="#helperHubModal" data-bs-toggle="modal">Kembali</button></div>
        </div>
    </div>
</div>

<div class="modal fade" id="devModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-glass">
            <div class="modal-header"><h5 class="modal-title fw-bold text-dark">Saran Developer</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form id="formKirimSaran" action="{{ route('saran.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div id="alertDev" class="alert d-none py-2 small"></div>
                    <div class="mb-3"><label class="form-label text-dark small fw-bold">Subjek</label><input type="text" id="subjekSaran" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label text-dark small fw-bold">Isi Masukan</label><textarea id="isiSaran" class="form-control" rows="3" required></textarea></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-sm btn-secondary" data-bs-target="#helperHubModal" data-bs-toggle="modal">Kembali</button><button type="submit" id="btnSubmitDev" class="btn btn-sm btn-success">Kirim</button></div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="devCheckModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-glass">
            <div class="modal-header"><h5 class="modal-title fw-bold text-dark">Lacak Tiket Dev</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <form id="formCekTiket" action="{{ route('saran.check') }}" method="POST">
                    @csrf
                    <div class="input-group"><input type="text" id="ticketCode" class="form-control" placeholder="Masukkan Kode Tiket" required><button class="btn btn-success btn-sm" type="submit">Cek</button></div>
                </form>
                <div id="hasilCek" class="d-none mt-3 p-3 rounded bg-light border text-dark small">
                    <h6 class="fw-bold" id="resSubjek"></h6>
                    <p class="mb-2" id="resIsi"></p>
                    <div class="p-2 border border-success rounded bg-white text-success"><strong>Balasan:</strong> <span id="resBalasan"></span></div>
                </div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-sm btn-secondary" data-bs-target="#helperHubModal" data-bs-toggle="modal">Kembali</button></div>
        </div>
    </div>
</div>

<script>
  // 1. Loading Login
  document.getElementById('formLoginUtama').addEventListener('submit', function() {
      this.querySelector('button[type="submit"]').innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';
  });

  // Helper Kirim Form AJAX (Lapor & Kirim Saran)
  function handleAjaxForm(formId, btnId, alertId, bodyBuilder) {
      document.getElementById(formId).addEventListener('submit', function(e) {
          e.preventDefault();
          const btn = document.getElementById(btnId); const alertBox = document.getElementById(alertId);
          btn.disabled = true; btn.innerText = 'Mengirim...';
          
          fetch(this.action, {
              method: 'POST',
              headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
              body: JSON.stringify(bodyBuilder(this))
          })
          .then(res => res.json()).then(data => {
              alertBox.classList.remove('d-none', 'alert-danger', 'alert-success');
              if(data.success) {
                  alertBox.classList.add('alert-success'); alertBox.innerHTML = `Sukses! Tiket: <strong>${data.ticket_code}</strong>`; this.reset();
              } else { alertBox.classList.add('alert-danger'); alertBox.innerText = data.message; }
          }).catch(() => { alertBox.classList.add('alert-danger'); alertBox.innerText = 'Sistem error.'; })
          .finally(() => { btn.disabled = false; btn.innerText = 'Kirim'; });
      });
  }

  handleAjaxForm('formKirimPengaduanSekolah', 'btnSubmitSchool', 'alertSchool', () => ({ judul: document.getElementById('judulPengaduan').value, isi_laporan: document.getElementById('isiPengaduan').value }));
  handleAjaxForm('formKirimSaran', 'btnSubmitDev', 'alertDev', () => ({ subjek: document.getElementById('subjekSaran').value, isi_saran: document.getElementById('isiSaran').value }));

  // 2. FIXED: AJAX Lacak Pengaduan Sekolah (Memperbaiki bentrokan variabel res)
  document.getElementById('formCekTiketSekolah').addEventListener('submit', function(e) {
      e.preventDefault(); 
      const btn = document.getElementById('btnCekSchool'); const hasil = document.getElementById('hasilCekSchool');
      btn.disabled = true;

      fetch(this.action, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
          body: JSON.stringify({ ticket_code: document.getElementById('schoolTicketCode').value })
      })
      .then(response => {
          if (!response.ok) {
              return response.json().then(err => { throw new Error(err.message || 'Tiket tidak ditemukan'); });
          }
          return response.json();
      })
      .then(result => {
          if(result.success) {
              document.getElementById('resSchoolJudul').innerText = result.data.judul;
              document.getElementById('resSchoolIsi').innerText = result.data.isi_laporan;
              document.getElementById('resSchoolStatus').innerText = result.data.status;
              document.getElementById('resSchoolTanggapan').innerText = result.data.tanggapan_admin;
              hasil.classList.remove('d-none');
          } else { alert(result.message); }
      })
      .catch((error) => {
          alert(error.message || 'Gagal memuat data pengaduan sekolah.');
          hasil.classList.add('d-none');
      })
      .finally(() => { btn.disabled = false; });
  });

  // 3. AJAX Cek Tiket Dev
  document.getElementById('formCekTiket').addEventListener('submit', function(e) {
      e.preventDefault(); const hasil = document.getElementById('hasilCek');
      fetch(this.action, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
          body: JSON.stringify({ ticket_code: document.getElementById('ticketCode').value })
      }).then(res => res.json()).then(res => {
          if(res.success) {
              document.getElementById('resSubjek').innerText = res.data.subjek;
              document.getElementById('resIsi').innerText = res.data.isi_saran;
              document.getElementById('resBalasan').innerText = res.data.reply_developer || 'Belum ada balasan.';
              hasil.classList.remove('d-none');
          } else { alert(res.message); }
      }).catch(() => alert('Gagal mencari tiket.'));
  });
</script>
@endsection