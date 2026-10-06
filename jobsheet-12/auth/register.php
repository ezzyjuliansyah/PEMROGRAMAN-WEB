<?php
$base = '../';
$pageTitle = 'Register - E-Sport';
$activePage = 'register';
include '../includes/header.php';
?>

<main>
    <div class="content-card">
        <h2>Form Register Petugas</h2>

        <form action="proses_register.php" method="post" id="form-register">
            <?= csrf_field() ?>
            <div>
                <label for="nama">Nama Lengkap:</label>
                <input type="text" id="nama" name="nama" required>
            </div>

            <div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" autocomplete="username" required>
            </div>

            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" minlength="6" autocomplete="new-password" required>
            </div>

            <div class="form-actions">
                <button type="submit" id="btn-register">Daftar</button>
                <button type="reset" id="btn-reset-register">Reset</button>
            </div>

            <p class="form-link">Sudah punya akun? <a href="login.php">Login di sini</a></p>
        </form>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
