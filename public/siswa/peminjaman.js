/**
 * Fungsi submit filter kategori dinamis tanpa merusak search parameter
 */
function filterByKategori(kategoriValue) {
    document.getElementById('filterKategoriInput').value = kategoriValue;
    document.getElementById('searchFilterForm').submit();
}

/**
 * Logika Alur Modal SweetAlert2 untuk Alur Peminjaman Buku
 */
function pinjamBukuLangsung(bookId, judulBuku) {
    const today = new Date().toISOString().split('T')[0];
    
    Swal.fire({
        title: 'Tentukan Tanggal',
        html: `
            <div class="text-start mb-2.5">
                <label class="small fw-bold text-secondary mb-1">Tanggal Mulai Pinjam:</label>
                <input type="date" id="swal_tgl_pinjam" class="form-control rounded-3" value="${today}" min="${today}">
            </div>
            <div class="text-start mb-1">
                <label class="small fw-bold text-secondary mb-1">Tanggal Batas Pengembalian:</label>
                <input type="date" id="swal_tgl_kembali" class="form-control rounded-3" min="${today}">
            </div>
        `,
        confirmButtonText: 'Lanjutkan Proses',
        confirmButtonColor: '#0d6efd',
        customClass: { popup: 'rounded-4' },
        preConfirm: () => {
            const tglPinjam = document.getElementById('swal_tgl_pinjam').value;
            const tglKembali = document.getElementById('swal_tgl_kembali').value;
            
            if (!tglPinjam || !tglKembali || new Date(tglKembali) < new Date(tglPinjam)) {
                Swal.showValidationMessage('Pastikan rentang tanggal sudah benar!'); 
                return false;
            }
            return { tglPinjam, tglKembali }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Konfirmasi Final', 
                text: `Apakah Anda yakin ingin mengajukan peminjaman untuk buku "${judulBuku}"?`, 
                icon: 'question', 
                showCancelButton: true, 
                confirmButtonText: 'Ya, Ajukan!', 
                cancelButtonText: 'Batal', 
                confirmButtonColor: '#0d6efd', 
                customClass: { popup: 'rounded-4' }
            }).then((konfirmasi) => {
                if (konfirmasi.isConfirmed) {
                    const form = document.getElementById('formKirimPinjam');
                    
                    // Set value tanggal ke hidden input form injeksi
                    document.getElementById('submit_tanggal_pinjam').value = result.value.tglPinjam;
                    document.getElementById('submit_tanggal_kembali').value = result.value.tglKembali;
                    
                    // Set URL action secara dinamis menuju ke SiswaController@pinjamBuku
                    form.action = `/siswa/pinjam/${bookId}`;
                    
                    // ADDED: Tampilkan animasi loading penahan transisi halaman agar langsung terlempar sempurna
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Mengirimkan pengajuan ke admin.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Submit form secara aman
                    form.submit();
                }
            });
        }
    });
}