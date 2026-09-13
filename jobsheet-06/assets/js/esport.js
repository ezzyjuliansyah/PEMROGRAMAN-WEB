// Jobsheet 6 - Fetch API & JSON: render Daftar Divisi dari data/divisi.json

document.addEventListener('DOMContentLoaded', function () {
    const tbody = document.getElementById('tabel-divisi-body');
    if (!tbody) return;

    muatDataDivisi(tbody);
});

function tundaSebentar(ms) {
    return new Promise(function (resolve) {
        setTimeout(resolve, ms);
    });
}

async function muatDataDivisi(tbody) {
    try {
        // Simulasi delay jaringan (600ms) supaya loading indicator terlihat jelas.
        await tundaSebentar(600);

        const response = await fetch('../data/divisi.json');

        if (!response.ok) {
            throw new Error('Server merespons dengan status ' + response.status);
        }

        const daftarDivisi = await response.json();
        renderDivisi(tbody, daftarDivisi);
    } catch (error) {
        tbody.innerHTML =
            '<tr class="error-row"><td colspan="5">Gagal memuat data divisi: ' +
            error.message +
            '</td></tr>';
    }
}

function renderDivisi(tbody, daftarDivisi) {
    tbody.innerHTML = '';

    daftarDivisi.forEach(function (divisi) {
        const row = document.createElement('tr');
        row.innerHTML =
            '<td>' + divisi.kode + '</td>' +
            '<td>' + divisi.nama_game + '</td>' +
            '<td>' + divisi.platform + '</td>' +
            '<td>' + divisi.roster + ' Player</td>' +
            '<td>' +
            '<button type="button">Edit</button> ' +
            '<button type="button" class="btn-hapus">Hapus</button>' +
            '</td>';
        tbody.appendChild(row);
    });
}
