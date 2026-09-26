<?php
$base = '../';
$pageTitle = 'Edit Divisi - E-Sport';
$activePage = 'divisi-list';
include '../includes/header.php';
require '../includes/koneksi.php';

$id = (int) ($_GET['id'] ?? 0);

$stmt = $pdo->prepare('SELECT * FROM divisi WHERE id = :id');
$stmt->execute(['id' => $id]);
$divisi = $stmt->fetch();

if (!$divisi) {
    $_SESSION['flash'] = ['type' => 'error', 'message' => 'Data divisi tidak ditemukan.'];
    header('Location: list.php');
    exit;
}
?>

<main>
    <div class="content-card">
        <h2>Form Edit Divisi</h2>

        <form action="proses_edit.php" method="post" id="form-divisi">
            <input type="hidden" name="id" value="<?= (int) $divisi['id'] ?>">

            <div>
                <label for="kode_divisi">Kode Divisi:</label>
                <input type="text" id="kode_divisi" name="kode_divisi" value="<?= e($divisi['kode']) ?>" required>
            </div>

            <div>
                <label for="nama_game">Nama Game:</label>
                <input type="text" id="nama_game" name="nama_game" value="<?= e($divisi['nama_game']) ?>" required>
            </div>

            <div>
                <label for="platform">Platform:</label>
                <input type="text" id="platform" name="platform" value="<?= e($divisi['platform']) ?>" required>
            </div>

            <div>
                <label for="roster">Jumlah Roster:</label>
                <input type="number" id="roster" name="roster" min="1" value="<?= e($divisi['roster']) ?>" required>
            </div>

            <div class="form-actions">
                <button type="submit" id="btn-simpan">Simpan Perubahan</button>
                <a href="list.php" class="btn-batal">Batal</a>
            </div>
        </form>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
