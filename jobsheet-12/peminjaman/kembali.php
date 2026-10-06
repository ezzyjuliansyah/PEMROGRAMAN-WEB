<?php
$base = '../';
require __DIR__ . '/../includes/auth.php';
$pageTitle = 'Pengembalian - E-Sport';
$activePage = 'peminjaman-kembali';
include '../includes/header.php';
require '../includes/koneksi.php';

// Hanya transaksi AKTIF (status = 'dipinjam'); yang sudah 'selesai' pindah ke Riwayat.
$stmt = $pdo->query(
    "SELECT p.id, p.tgl_pinjam, a.no_anggota, a.nama, d.kode, d.nama_game
     FROM peminjaman p
     JOIN anggota a ON a.id = p.anggota_id
     JOIN divisi d ON d.id = p.divisi_id
     WHERE p.status = 'dipinjam'
     ORDER BY p.tgl_pinjam DESC, p.id DESC"
);
$daftarAktif = $stmt->fetchAll();
?>

<main>
    <div class="content-card">
        <h2>Pengembalian Player</h2>

        <div class="table-responsive">
            <table id="tabel-peminjaman-aktif">
                <thead>
                    <tr>
                        <th>Tgl Pinjam</th>
                        <th>Player</th>
                        <th>Divisi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($daftarAktif)): ?>
                        <tr><td colspan="4">Tidak ada peminjaman aktif.</td></tr>
                    <?php else: ?>
                        <?php foreach ($daftarAktif as $p): ?>
                            <tr>
                                <td><?= e(date('d-m-Y H:i', strtotime($p['tgl_pinjam']))) ?></td>
                                <td><?= e($p['no_anggota']) ?> - <?= e($p['nama']) ?></td>
                                <td><?= e($p['kode']) ?> - <?= e($p['nama_game']) ?></td>
                                <td class="aksi-cell">
                                    <form action="proses_kembali.php" method="post" class="form-kembali">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="id" value="<?= (int) $p['id'] ?>">
                                        <button type="submit" class="btn-kembali">Kembalikan</button>
                                    </form>
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
