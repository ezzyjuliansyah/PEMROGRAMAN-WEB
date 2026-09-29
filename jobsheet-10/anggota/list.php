<?php
$base = '../';
require __DIR__ . '/../includes/auth.php';
$pageTitle = 'Daftar Anggota - E-Sport';
$activePage = 'anggota-list';
include '../includes/header.php';
require '../includes/koneksi.php';

$q = $_GET['q'] ?? '';

$perPage = 5;
$page = max(1, (int) ($_GET['page'] ?? 1));
$offset = ($page - 1) * $perPage;

if ($q !== '') {
    $where = 'WHERE no_anggota ILIKE :kw OR nama ILIKE :kw OR role ILIKE :kw';

    $countStmt = $pdo->prepare("SELECT COUNT(*) FROM anggota $where");
    $countStmt->execute(['kw' => '%' . $q . '%']);
    $totalRows = (int) $countStmt->fetchColumn();

    $stmt = $pdo->prepare("SELECT * FROM anggota $where ORDER BY id DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue('kw', '%' . $q . '%');
    $stmt->bindValue('limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue('offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
} else {
    $totalRows = (int) $pdo->query('SELECT COUNT(*) FROM anggota')->fetchColumn();

    $stmt = $pdo->prepare('SELECT * FROM anggota ORDER BY id DESC LIMIT :limit OFFSET :offset');
    $stmt->bindValue('limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue('offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
}

$daftarAnggota = $stmt->fetchAll();
$totalPages = max(1, (int) ceil($totalRows / $perPage));
?>

<main>
    <div class="content-card">
        <h2>Daftar Anggota Player</h2>

        <form action="list.php" method="get" class="search-box">
            <label for="search-input">🔎 Cari data (server, semua halaman):</label>
            <!-- Sama seperti esport/list.php: nilai $q SENGAJA belum di-escape
                 saat ditampilkan balik ke value= - diperbaiki di Jobsheet 11. -->
            <input type="search" id="search-input" name="q" value="<?= $q ?>"
                placeholder="Cari nama player, role, atau nomor anggota...">
            <button type="submit">Cari</button>
            <?php if ($q !== ''): ?>
                <a href="list.php" class="btn-reset-cari">Reset</a>
            <?php endif; ?>
        </form>

        <div class="search-box">
            <label for="search-tabel-anggota">🔎 Filter cepat baris di halaman ini:</label>
            <input type="search" id="search-tabel-anggota" data-table-search="tabel-anggota"
                placeholder="Filter di antara baris yang sedang tampil..." autocomplete="off">
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
                        <tr><td colspan="5">Tidak ada data anggota yang cocok.</td></tr>
                    <?php else: ?>
                        <?php foreach ($daftarAnggota as $anggota): ?>
                            <tr>
                                <td><?= e($anggota['no_anggota']) ?></td>
                                <td><?= e($anggota['nama']) ?></td>
                                <td><?= e($anggota['role']) ?></td>
                                <td><?= e($anggota['no_hp']) ?></td>
                                <td class="aksi-cell">
                                    <a href="edit.php?id=<?= (int) $anggota['id'] ?>" class="btn-edit">Edit</a>
                                    <form action="hapus.php" method="post" class="form-hapus">
                                        <input type="hidden" name="id" value="<?= (int) $anggota['id'] ?>">
                                        <button type="submit" class="btn-hapus">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if ($totalPages > 1): ?>
            <nav class="pagination">
                <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                    <a href="list.php?page=<?= $p ?><?= $q !== '' ? '&q=' . urlencode($q) : '' ?>"
                       class="<?= $p === $page ? 'active' : '' ?>"><?= $p ?></a>
                <?php endfor; ?>
            </nav>
        <?php endif; ?>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
