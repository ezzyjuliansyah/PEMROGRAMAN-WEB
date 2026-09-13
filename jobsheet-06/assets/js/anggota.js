// Jobsheet 6 - Fetch API & JSON: render Daftar Anggota dari data/anggota.json

document.addEventListener('DOMContentLoaded', function () {
    const tbody = document.getElementById('tabel-anggota-body');
    if (!tbody) return;

    muatDataAnggota(tbody);
});

function tundaSebentar(ms) {
    return new Promise(function (resolve) {
        setTimeout(resolve, ms);
    });
}

async function muatDataAnggota(tbody) {
    try {
        // Simulasi delay jaringan (600ms) supaya loading indicator terlihat jelas.
        await tundaSebentar(600);

        const response = await fetch('../data/anggota.json');

        if (!response.ok) {
            throw new Error('Server merespons dengan status ' + response.status);
        }

        const daftarAnggota = await response.json();
        renderAnggota(tbody, daftarAnggota);
    } catch (error) {
        tbody.innerHTML =
            '<tr class="error-row"><td colspan="5">Gagal memuat data anggota: ' +
            error.message +
            '</td></tr>';
    }
}

function renderAnggota(tbody, daftarAnggota) {
    tbody.innerHTML = '';

    daftarAnggota.forEach(function (anggota) {
        const row = document.createElement('tr');
        row.innerHTML =
            '<td>' + anggota.no_anggota + '</td>' +
            '<td>' + anggota.nama + '</td>' +
            '<td>' + anggota.role + '</td>' +
            '<td>' + anggota.no_hp + '</td>' +
            '<td>' +
            '<button type="button">Edit</button> ' +
            '<button type="button" class="btn-hapus">Hapus</button>' +
            '</td>';
        tbody.appendChild(row);
    });
}
