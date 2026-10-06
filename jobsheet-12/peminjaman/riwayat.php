<?php
$base = '../';
require __DIR__ . '/../includes/auth.php';
$pageTitle = 'Riwayat Peminjaman - E-Sport';
$activePage = 'peminjaman-riwayat';
include '../includes/header.php';
require '../includes/koneksi.php';

$daftarAnggota = $pdo->query('SELECT id, no_anggota, nama FROM anggota ORDER BY nama')->fetchAll();

// Anggota dipilih lewat GET (?anggota_id=...), jadi hasilnya bisa di-bookmark.
$anggotaId = (int) ($_GET['anggota_id'] ?? 0);
$riwayat = [];
$anggotaDipilih = null;

if ($anggotaId > 0) {
    $cekAnggota = $pdo->prepare('SELECT id, no_anggota, nama FROM anggota WHERE id = :id');
    $cekAnggota->execute(['id' => $anggotaId]);
    $anggotaDipilih = $cekAnggota->fetch();

    if ($anggotaDipilih) {
        $stmt = $pdo->prepare(
            'SELECT p.tgl_pinjam, p.tgl_kembali, p.status, d.kode, d.nama_game
             FROM peminjaman p
             JOIN divisi d ON d.id = p.divisi_id
             WHERE p.anggota_id = :anggota_id
             ORDER BY p.tgl_pinjam DESC, p.id DESC'
        );
        $stmt->execute(['anggota_id' => $anggotaId]);
        $riwayat = $stmt->fetchAll();
    }
}
?>

<main>
    <div class="content-card">
        <h2>Riwayat Peminjaman per Player</h2>

        <form action="riwayat.php" method="get" class="search-box">
            <label for="anggota_id">Pilih player:</label>
            <select id="anggota_id" name="anggota_id" required>
                <option value="">-- Pilih player --</option>
                <?php foreach ($daftarAnggota as $a): ?>
                    <option value="<?= (int) $a['id'] ?>" <?= $anggotaId === (int) $a['id'] ? 'selected' : '' ?>>
                        <?= e($a['no_anggota']) ?> - <?= e($a['nama']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Tampilkan</button>
        </form>

        <?php if ($anggotaId > 0 && !$anggotaDipilih): ?>
            <p class="welcome-text">Player tidak ditemukan.</p>
        <?php elseif ($anggotaDipilih): ?>
            <h3 class="stat-section-title">Riwayat: <?= e($anggotaDipilih['nama']) ?> (<?= e($anggotaDipilih['no_anggota']) ?>)</h3>

            <div class="table-responsive">
                <table id="tabel-riwayat">
                    <thead>
                        <tr>
                            <th>Divisi</th>
                            <th>Tgl Pinjam</th>
                            <th>Tgl Kembali</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($riwayat)): ?>
                            <tr><td colspan="4">Player ini belum pernah dipinjam.</td></tr>
                        <?php else: ?>
                            <?php foreach ($riwayat as $r): ?>
                                <tr>
                                    <td><?= e($r['kode']) ?> - <?= e($r['nama_game']) ?></td>
                                    <td><?= e(date('d-m-Y H:i', strtotime($r['tgl_pinjam']))) ?></td>
                                    <td><?= $r['tgl_kembali'] ? e(date('d-m-Y H:i', strtotime($r['tgl_kembali']))) : '-' ?></td>
                                    <td>
                                        <?php if ($r['status'] === 'dipinjam'): ?>
                                            <span class="badge badge-aktif">Dipinjam</span>
                                        <?php else: ?>
                                            <span class="badge badge-selesai">Selesai</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
