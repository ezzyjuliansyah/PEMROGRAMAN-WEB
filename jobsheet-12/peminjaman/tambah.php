<?php
$base = '../';
require __DIR__ . '/../includes/auth.php';
$pageTitle = 'Peminjaman Baru - E-Sport';
$activePage = 'peminjaman-tambah';
include '../includes/header.php';
require '../includes/koneksi.php';

// Dropdown divisi HANYA menampilkan divisi yang masih punya slot (roster > 0),
// jadi divisi yang penuh tidak bisa dipilih.
$daftarAnggota = $pdo->query('SELECT id, no_anggota, nama, role FROM anggota ORDER BY nama')->fetchAll();
$daftarDivisi = $pdo->query('SELECT id, kode, nama_game, roster FROM divisi WHERE roster > 0 ORDER BY nama_game')->fetchAll();
?>

<main>
    <div class="content-card">
        <h2>Form Peminjaman Player</h2>

        <?php if (empty($daftarAnggota) || empty($daftarDivisi)): ?>
            <p class="welcome-text">
                Peminjaman belum bisa dibuat:
                <?php if (empty($daftarAnggota)): ?>belum ada data anggota. <a href="../anggota/tambah.php">Tambah anggota</a>.<?php endif; ?>
                <?php if (empty($daftarDivisi)): ?>tidak ada divisi dengan slot roster tersisa. <a href="../esport/tambah.php">Tambah divisi</a>.<?php endif; ?>
            </p>
        <?php else: ?>
            <form action="proses_tambah.php" method="post" id="form-peminjaman">
                <?= csrf_field() ?>

                <div>
                    <label for="anggota_id">Player (Anggota):</label>
                    <select id="anggota_id" name="anggota_id" required>
                        <option value="">-- Pilih player --</option>
                        <?php foreach ($daftarAnggota as $a): ?>
                            <option value="<?= (int) $a['id'] ?>"><?= e($a['no_anggota']) ?> - <?= e($a['nama']) ?> (<?= e($a['role']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="divisi_id">Divisi Game (hanya yang slotnya tersisa):</label>
                    <select id="divisi_id" name="divisi_id" required>
                        <option value="">-- Pilih divisi --</option>
                        <?php foreach ($daftarDivisi as $d): ?>
                            <option value="<?= (int) $d['id'] ?>"><?= e($d['kode']) ?> - <?= e($d['nama_game']) ?> (sisa slot: <?= e($d['roster']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="submit" id="btn-pinjam">Simpan Peminjaman</button>
                    <button type="reset" id="btn-reset-pinjam">Reset</button>
                </div>
            </form>
        <?php endif; ?>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
