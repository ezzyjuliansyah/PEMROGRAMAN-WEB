<?php
$base = '../';
$pageTitle = 'Tambah Divisi - E-Sport';
$activePage = 'divisi-tambah';
include '../includes/header.php';
?>

<main>
    <div class="content-card">
        <h2>Form Tambah Divisi</h2>

        <form action="proses_tambah.php" method="post" id="form-divisi">
            <div>
                <label for="kode_divisi">Kode Divisi:</label>
                <input type="text" id="kode_divisi" name="kode_divisi" required>
            </div>

            <div>
                <label for="nama_game">Nama Game:</label>
                <input type="text" id="nama_game" name="nama_game" required>
            </div>

            <div>
                <label for="platform">Platform:</label>
                <input type="text" id="platform" name="platform" required>
            </div>

            <div>
                <label for="roster">Jumlah Roster:</label>
                <input type="number" id="roster" name="roster" min="1" required>
            </div>

            <div class="form-actions">
                <button type="submit" id="btn-simpan">Simpan</button>
                <button type="reset" id="btn-reset">Reset</button>
            </div>
        </form>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
