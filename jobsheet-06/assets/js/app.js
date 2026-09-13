// Jobsheet 6 - Fetch API & JSON (lanjutan Jobsheet 5)

document.addEventListener('DOMContentLoaded', function () {
    // ==============================
    // 1. Hamburger Menu
    // ==============================
    const menuButton = document.querySelector('.nav-toggle-label');
    const nav = document.querySelector('nav');

    if (menuButton && nav) {
        menuButton.addEventListener('click', function () {
            nav.classList.toggle('nav-open');
            const isOpen = nav.classList.contains('nav-open');
            menuButton.setAttribute('aria-expanded', isOpen);
            menuButton.textContent = isOpen ? '✕' : '☰';
        });
    }

    // ==============================
    // 2. Filter Tabel Real-Time
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
    // 3. Konfirmasi Hapus (Event Delegation)
    // ==============================
    // Jobsheet 5: tombol .btn-hapus sudah ada saat halaman dimuat, jadi bisa
    // langsung diberi event listener satu per satu (querySelectorAll + forEach).
    //
    // Jobsheet 6: baris tabel (dan tombol Hapus di dalamnya) baru dibuat SETELAH
    // fetch() selesai, alias setelah DOMContentLoaded. Listener yang dipasang
    // langsung ke tombol tidak akan pernah terpasang, karena tombolnya belum
    // ada saat kode ini berjalan.
    //
    // Solusinya: pasang SATU listener di `document`, lalu deteksi target klik
    // memakai event.target.closest('.btn-hapus'). Pola ini disebut
    // "event delegation" - listener tetap berfungsi untuk elemen yang dibuat
    // kapan saja, termasuk elemen yang baru muncul belakangan.
    initHapusConfirm();
});

function initHapusConfirm() {
    document.addEventListener('click', function (event) {
        const button = event.target.closest('.btn-hapus');
        if (!button) return;

        const row = button.closest('tr');
        const namaData = row ? row.children[1].textContent.trim() : 'data ini';

        const yakin = confirm('Apakah kamu yakin ingin menghapus ' + namaData + '?');

        if (yakin && row) {
            row.remove();
        }
    });
}

// ==============================
// 4 & 5. Validasi Form (Anggota & Divisi)
// ==============================
document.addEventListener('DOMContentLoaded', function () {
    const formAnggota = document.getElementById('form-anggota');

    if (formAnggota) {
        formAnggota.addEventListener('submit', function (event) {
            event.preventDefault();
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

            if (valid) {
                showSuccess(formAnggota, 'Data anggota berhasil divalidasi. Form siap dikirim.');
            }
        });
    }

    const formDivisi = document.getElementById('form-divisi');

    if (formDivisi) {
        formDivisi.addEventListener('submit', function (event) {
            event.preventDefault();
            clearErrors(formDivisi);

            const kode = document.getElementById('kode_divisi');
            const namaGame = document.getElementById('nama_game');
            const platform = document.getElementById('platform');
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

            if (valid) {
                showSuccess(formDivisi, 'Data divisi berhasil divalidasi. Form siap dikirim.');
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

    const success = form.querySelector('.success-message');
    if (success) success.remove();
}

function showSuccess(form, message) {
    const success = document.createElement('div');
    success.className = 'success-message';
    success.textContent = message;
    form.prepend(success);
}
