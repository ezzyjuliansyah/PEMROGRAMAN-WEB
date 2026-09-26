<?php
$base = '../';
$pageTitle = 'Daftar Divisi - E-Sport';
$activePage = 'divisi-list';
include '../includes/header.php';
require '../includes/koneksi.php';

// ==============================
// Pencarian server-side (Jobsheet 9)
// ==============================
// Sebelumnya (Jobsheet 5/6) kolom cari cuma filter baris yang SUDAH tampil
// di browser (client-side). Sekarang #search-input mengirim GET ?q=...
// dan query ke database beneran mencari lewat semua data (ILIKE = LIKE
// yang case-insensitive di PostgreSQL).
$q = $_GET['q'] ?? '';

// ==============================
// Pagination (Jobsheet 9)
// ==============================
$perPage = 5;
$page = max(1, (int) ($_GET['page'] ?? 1));
$offset = ($page - 1) * $perPage;

if ($q !== '') {
    $where = 'WHERE kode ILIKE :kw OR nama_game ILIKE :kw OR platform ILIKE :kw';

    $countStmt = $pdo->prepare("SELECT COUNT(*) FROM divisi $where");
    $countStmt->execute(['kw' => '%' . $q . '%']);
    $totalRows = (int) $countStmt->fetchColumn();

    $stmt = $pdo->prepare("SELECT * FROM divisi $where ORDER BY id DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue('kw', '%' . $q . '%');
    $stmt->bindValue('limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue('offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
} else {
    $totalRows = (int) $pdo->query('SELECT COUNT(*) FROM divisi')->fetchColumn();

    $stmt = $pdo->prepare('SELECT * FROM divisi ORDER BY id DESC LIMIT :limit OFFSET :offset');
    $stmt->bindValue('limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue('offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
}

$daftarDivisi = $stmt->fetchAll();
$totalPages = max(1, (int) ceil($totalRows / $perPage));
?>

<main>
    <div class="content-card">
        <h2>Daftar Divisi Game</h2>

        <form action="list.php" method="get" class="search-box">
            <label for="search-input">🔎 Cari data (server, semua halaman):</label>
            <!--
                CATATAN (sengaja, lihat Jobsheet 9 poin Catatan):
                Nilai $q di bawah ini SENGAJA ditampilkan balik ke value=
                TANPA htmlspecialchars/e(). Ini belum aman terhadap XSS -
                audit & perbaikan menyeluruh dilakukan di Jobsheet 11.
            -->
            <input type="search" id="search-input" name="q" value="<?= $q ?>"
                placeholder="Cari kode divisi, nama game, atau platform...">
            <button type="submit">Cari</button>
            <?php if ($q !== ''): ?>
                <a href="list.php" class="btn-reset-cari">Reset</a>
            <?php endif; ?>
        </form>

        <div class="search-box">
            <label for="search-tabel-divisi">🔎 Filter cepat baris di halaman ini:</label>
            <input type="search" id="search-tabel-divisi" data-table-search="tabel-divisi"
                placeholder="Filter di antara baris yang sedang tampil..." autocomplete="off">
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
                    <?php if (empty($daftarDivisi)): ?>
                        <tr><td colspan="5">Tidak ada data divisi yang cocok.</td></tr>
                    <?php else: ?>
                        <?php foreach ($daftarDivisi as $divisi): ?>
                            <tr>
                                <td><?= e($divisi['kode']) ?></td>
                                <td><?= e($divisi['nama_game']) ?></td>
                                <td><?= e($divisi['platform']) ?></td>
                                <td><?= e($divisi['roster']) ?> Player</td>
                                <td class="aksi-cell">
                                    <a href="edit.php?id=<?= (int) $divisi['id'] ?>" class="btn-edit">Edit</a>
                                    <form action="hapus.php" method="post" class="form-hapus">
                                        <input type="hidden" name="id" value="<?= (int) $divisi['id'] ?>">
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
