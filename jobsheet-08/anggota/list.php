<?php
$base = '../';
$pageTitle = 'Daftar Anggota - E-Sport';
$activePage = 'anggota-list';
include '../includes/header.php';
require '../includes/koneksi.php';

$daftarAnggota = $pdo->query('SELECT * FROM anggota ORDER BY id DESC')->fetchAll();
?>

<main>
    <div class="content-card">
        <h2>Daftar Anggota Player</h2>

        <div class="search-box">
            <label for="search-tabel-anggota">🔎 Cari data:</label>
            <input type="search" id="search-tabel-anggota" data-table-search="tabel-anggota"
                placeholder="Cari nama player, role, atau nomor anggota..." autocomplete="off">
        </div>

        <div class="table-responsive">
            <table id="tabel-anggota">
                <thead>
                    <tr>
                        <th>No. Anggota</th>
                        <th>Nama Player</th>
                        <th>Role / Posisi</th>
                        <th>No. HP</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($daftarAnggota)): ?>
                        <tr><td colspan="5">Belum ada data anggota.</td></tr>
                    <?php else: ?>
                        <?php foreach ($daftarAnggota as $anggota): ?>
                            <tr>
                                <td><?= e($anggota['no_anggota']) ?></td>
                                <td><?= e($anggota['nama']) ?></td>
                                <td><?= e($anggota['role']) ?></td>
                                <td><?= e($anggota['no_hp']) ?></td>
                                <td>
                                    <button type="button">Edit</button>
                                    <button type="button" class="btn-hapus">Hapus</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
