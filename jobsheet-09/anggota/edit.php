<?php
$base = '../';
$pageTitle = 'Edit Anggota - E-Sport';
$activePage = 'anggota-list';
include '../includes/header.php';
require '../includes/koneksi.php';

$id = (int) ($_GET['id'] ?? 0);

$stmt = $pdo->prepare('SELECT * FROM anggota WHERE id = :id');
$stmt->execute(['id' => $id]);
$anggota = $stmt->fetch();

if (!$anggota) {
    $_SESSION['flash'] = ['type' => 'error', 'message' => 'Data anggota tidak ditemukan.'];
    header('Location: list.php');
    exit;
}
?>

<main>
    <div class="content-card">
        <h2>Form Edit Anggota Player</h2>

        <form action="proses_edit.php" method="post" id="form-anggota">
            <input type="hidden" name="id" value="<?= (int) $anggota['id'] ?>">

            <div>
                <label for="no_anggota">No. Anggota:</label>
                <input type="text" id="no_anggota" name="no_anggota" value="<?= e($anggota['no_anggota']) ?>" required>
            </div>

            <div>
                <label for="nama">Nama Player:</label>
                <input type="text" id="nama" name="nama" value="<?= e($anggota['nama']) ?>" required>
            </div>

            <div>
                <label for="role">Role / Posisi:</label>
                <input type="text" id="role" name="role" value="<?= e($anggota['role']) ?>" required>
            </div>

            <div>
                <label for="no_hp">No. HP:</label>
                <input type="tel" id="no_hp" name="no_hp" inputmode="numeric" value="<?= e($anggota['no_hp']) ?>" required>
            </div>

            <div class="form-actions">
                <button type="submit" id="btn-simpan-anggota">Simpan Perubahan</button>
                <a href="list.php" class="btn-batal">Batal</a>
            </div>
        </form>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
