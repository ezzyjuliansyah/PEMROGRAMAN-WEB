<?php
$base = '../';
$pageTitle = 'Tambah Anggota - E-Sport';
$activePage = 'anggota-tambah';
include '../includes/header.php';
?>

<main>
    <div class="content-card">
        <h2>Form Tambah Anggota Player</h2>

        <form action="proses_tambah.php" method="post" id="form-anggota">
            <div>
                <label for="no_anggota">No. Anggota:</label>
                <input type="text" id="no_anggota" name="no_anggota" required>
            </div>

            <div>
                <label for="nama">Nama Player:</label>
                <input type="text" id="nama" name="nama" required>
            </div>

            <div>
                <label for="role">Role / Posisi:</label>
                <input type="text" id="role" name="role" required>
            </div>

            <div>
                <label for="no_hp">No. HP:</label>
                <input type="tel" id="no_hp" name="no_hp" inputmode="numeric" required>
            </div>

            <div class="form-actions">
                <button type="submit" id="btn-simpan-anggota">Simpan</button>
                <button type="reset" id="btn-reset-anggota">Reset</button>
            </div>
        </form>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
