<?php
$base = '../';
$pageTitle = 'Daftar Divisi - E-Sport';
$activePage = 'divisi-list';
include '../includes/header.php';
?>

<main>
    <div class="content-card">
        <h2>Daftar Divisi Game</h2>

        <div class="search-box">
            <label for="search-tabel-divisi">🔎 Cari data:</label>
            <input type="search" id="search-tabel-divisi" data-table-search="tabel-divisi"
                placeholder="Cari kode divisi, nama game, atau platform..." autocomplete="off">
        </div>

        <div class="table-responsive">
            <table id="tabel-divisi">
                <thead>
                    <tr>
                        <th>Kode Divisi</th>
                        <th>Nama Game</th>
                        <th>Platform</th>
                        <th>Jumlah Roster</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($_SESSION['divisi'])): ?>
                        <tr>
                            <td colspan="5">Belum ada data divisi.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($_SESSION['divisi'] as $divisi): ?>
                            <tr>
                                <td><?= e($divisi['kode']) ?></td>
                                <td><?= e($divisi['nama_game']) ?></td>
                                <td><?= e($divisi['platform']) ?></td>
                                <td><?= e($divisi['roster']) ?> Player</td>
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
