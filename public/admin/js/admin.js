/*
|--------------------------------------------------------------------------
| Admin Layout JavaScript
|--------------------------------------------------------------------------
| Realtime Clock
| Theme Switch
| Local Storage
|--------------------------------------------------------------------------
*/

document.addEventListener('DOMContentLoaded', function () {

    // ==========================
    // REALTIME CLOCK
    // ==========================
    function updateClock() {

        const clock = document.getElementById('realtimeClock');

        if (!clock) return;

        const now = new Date();

        const tanggal = now.toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });
        const jam = now.toLocaleTimeString('id-ID');
        clock.innerHTML = tanggal + ' | ' + jam;
    }

    updateClock();

    setInterval(updateClock, 1000);

    // ==========================
    // THEME SWITCH
    // ==========================
    const switchBtn = document.getElementById('themeSwitch');
    const label = document.getElementById('themeLabel');

    if (localStorage.getItem('theme') === 'light') {

        document.body.classList.add('light-mode');

        if (switchBtn) {
            switchBtn.checked = true;
        }

        if (label) {
            label.innerHTML = 'Dark Mode';
        }

    }

    if (switchBtn) {
        switchBtn.addEventListener('change', function () {
            document.body.classList.toggle('light-mode');
            if (document.body.classList.contains('light-mode')) {
                localStorage.setItem('theme', 'light');
                if (label) {
                    label.innerHTML = 'Dark Mode';
                }
            } else {
                localStorage.setItem('theme', 'dark');
                if (label) {
                    label.innerHTML = 'Light Mode';
                }
            }
        });
    }
});