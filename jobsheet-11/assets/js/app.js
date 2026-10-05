// Jobsheet 11 - Keamanan Web Dasar (JS tidak berubah dari Jobsheet 10)
// Validasi JavaScript tetap dipertahankan sebagai validasi awal.
// Validasi utama tetap dilakukan ulang di file proses_tambah.php / proses_edit.php.

document.addEventListener('DOMContentLoaded', function () {
    // ==============================
    // 1. Hamburger Menu
    // ==============================
    const menuButton = document.querySelector('.nav-toggle-label');
    const nav = document.querySelector('nav.site-nav');

    if (menuButton && nav) {
        menuButton.addEventListener('click', function () {
            nav.classList.toggle('nav-open');
            const isOpen = nav.classList.contains('nav-open');
            menuButton.setAttribute('aria-expanded', isOpen);
            menuButton.textContent = isOpen ? '✕' : '☰';
        });
    }

    // ==============================
    // 2. Filter Tabel Real-Time (client-side, hanya baris di halaman ini)
    // ==============================
    const searchInputs = document.querySelectorAll('[data-table-search]');

    searchInputs.forEach(function (input) {
        const tableId = input.getAttribute('data-table-search');
        const table = document.getElementById(tableId);

        if (!table) return;

        input.addEventListener('input', function () {
            const keyword = input.value.toLowerCase().trim();
            const rows = table.querySelectorAll('tbody tr');

            rows.forEach(function (row) {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(keyword) ? '' : 'none';
            });
        });
    });

    // ==============================
    // 3. Konfirmasi Hapus (Jobsheet 9)
    // ==============================
    // PERUBAHAN dari Jobsheet 6/7/8: tombol Hapus sekarang ada di dalam
    // <form class="form-hapus" method="post"> sungguhan (bukan cuma
    // <button> polos yang cuma menghapus baris di tampilan). Makanya
    // konfirmasi sekarang dipasang di event "submit" pada FORM-nya, bukan
    // "click" pada tombolnya:
    // - kalau user pilih Batal -> event.preventDefault() -> form TIDAK
    //   jadi terkirim -> data tetap aman di database.
    // - kalau user pilih OK -> event dibiarkan jalan -> form benar-benar
    //   submit ke hapus.php -> data betulan terhapus dari database.
    initHapusConfirm();
});

function initHapusConfirm() {
    document.addEventListener('submit', function (event) {
        const form = event.target.closest('.form-hapus');
        if (!form) return;

        const row = form.closest('tr');
        const namaData = row ? row.children[1].textContent.trim() : 'data ini';

        const yakin = confirm('Apakah kamu yakin ingin menghapus ' + namaData + '?');

        if (!yakin) {
            event.preventDefault();
        }
    });
}

// ==============================
// 4. Validasi Form Anggota (dipakai di tambah.php DAN edit.php, id form sama)
// ==============================
document.addEventListener('DOMContentLoaded', function () {
    const formAnggota = document.getElementById('form-anggota');

    if (formAnggota) {
        formAnggota.addEventListener('submit', function (event) {
            clearErrors(formAnggota);

            const noAnggota = document.getElementById('no_anggota');
            const nama = document.getElementById('nama');
            const role = document.getElementById('role');
            const noHp = document.getElementById('no_hp');
            let valid = true;

            if (noAnggota.value.trim() === '') {
                showError(noAnggota, 'No. anggota wajib diisi.');
                valid = false;
            }

            if (nama.value.trim() === '') {
                showError(nama, 'Nama player wajib diisi.');
                valid = false;
            }

            if (role.value.trim() === '') {
                showError(role, 'Role / posisi wajib diisi.');
                valid = false;
            }

            if (noHp.value.trim() === '') {
                showError(noHp, 'No. HP wajib diisi.');
                valid = false;
            } else if (!/^08\d{8,13}$/.test(noHp.value.trim())) {
                showError(noHp, 'No. HP harus berupa angka dan diawali 08.');
                valid = false;
            }

            if (!valid) {
                event.preventDefault();
            }
        });
    }

    // ==============================
    // 5. Validasi Form Divisi (dipakai di tambah.php DAN edit.php)
    // ==============================
    const formDivisi = document.getElementById('form-divisi');

    if (formDivisi) {
        formDivisi.addEventListener('submit', function (event) {
            clearErrors(formDivisi);

            const kode = document.getElementById('kode_divisi');
            const namaGame = document.getElementById('nama_game');
            const platform = document.getElementById('platform');
            const roster = document.getElementById('roster');
            let valid = true;

            if (kode.value.trim() === '') {
                showError(kode, 'Kode divisi wajib diisi.');
                valid = false;
            }

            if (namaGame.value.trim() === '') {
                showError(namaGame, 'Nama game wajib diisi.');
                valid = false;
            }

            if (platform.value.trim() === '') {
                showError(platform, 'Platform wajib diisi.');
                valid = false;
            }

            if (roster.value.trim() === '' || Number(roster.value) < 1) {
                showError(roster, 'Jumlah roster minimal 1.');
                valid = false;
            }

            if (!valid) {
                event.preventDefault();
            }
        });
    }
});

function showError(input, message) {
    input.classList.add('input-error');

    const error = document.createElement('small');
    error.className = 'error-message';
    error.textContent = message;
    input.parentElement.appendChild(error);
}

function clearErrors(form) {
    form.querySelectorAll('.error-message').forEach(function (element) {
        element.remove();
    });

    form.querySelectorAll('.input-error').forEach(function (element) {
        element.classList.remove('input-error');
    });
}
