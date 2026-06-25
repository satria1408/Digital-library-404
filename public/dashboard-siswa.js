document.addEventListener('DOMContentLoaded', function () {
    const themeBtn = document.getElementById('themeBtn');

    if (themeBtn) {
        function updateThemeButton() {
            if (document.body.classList.contains('dark-mode')) {
                themeBtn.textContent = 'Light Mode';
                themeBtn.classList.remove('btn-dark');
                themeBtn.classList.add('btn-light');
            } else {
                themeBtn.textContent = 'Dark Mode';
                themeBtn.classList.remove('btn-light');
                themeBtn.classList.add('btn-dark');
            }
        }

        if (localStorage.getItem('theme') === 'dark') {
            document.body.classList.add('dark-mode');
        }

        updateThemeButton();

        themeBtn.addEventListener('click', function () {
            document.body.classList.toggle('dark-mode');
            localStorage.setItem(
                'theme',
                document.body.classList.contains('dark-mode') ? 'dark' : 'light'
            );
            updateThemeButton();
        });
    }

    /* ===== LOGIC MODAL KALENDER PEMINJAMAN ===== */
    document.querySelectorAll('.btn-trigger-pinjam').forEach(button => {
        button.addEventListener('click', function () {
            const bookId = this.getAttribute('data-id');
            const bookJudul = this.getAttribute('data-judul');

            const modalBukuJudul = document.getElementById('modalBukuJudul');
            const formKalenderPinjam = document.getElementById('formKalenderPinjam');

            if (modalBukuJudul && formKalenderPinjam) {
                modalBukuJudul.textContent = bookJudul;
                formKalenderPinjam.setAttribute('action', `/siswa/pinjam/${bookId}`);

                const dtHariIni = new Date();
                const formatHariIni = dtHariIni.toISOString().split('T')[0];

                const dtMaksimal = new Date();
                dtMaksimal.setDate(dtHariIni.getDate() + 30);
                const formatMaksimal = dtMaksimal.toISOString().split('T')[0];

                const inputPinjam = document.getElementById('tanggal_pinjam');
                const inputKembali = document.getElementById('tanggal_kembali');

                if (inputPinjam && inputKembali) {
                    inputPinjam.value = formatHariIni;
                    inputPinjam.setAttribute('min', formatHariIni);

                    inputKembali.value = formatHariIni;
                    inputKembali.setAttribute('min', formatHariIni);
                    inputKembali.setAttribute('max', formatMaksimal);

                    inputPinjam.addEventListener('change', function () {
                        inputKembali.setAttribute('min', this.value);

                        const dtPinjamBaru = new Date(this.value);
                        const dtMaksBaru = new Date(dtPinjamBaru);
                        dtMaksBaru.setDate(dtPinjamBaru.getDate() + 30);

                        inputKembali.setAttribute('max', dtMaksBaru.toISOString().split('T')[0]);
                    });
                }

                const kalenderModal = new bootstrap.Modal(document.getElementById('kalenderPinjamModal'));
                kalenderModal.show();
            }
        });
    });
});