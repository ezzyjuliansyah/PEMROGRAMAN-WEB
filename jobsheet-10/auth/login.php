<?php
$base = '../';
$pageTitle = 'Login - E-Sport';
$activePage = 'login';
include '../includes/header.php';
?>

<main>
    <div class="content-card">
        <h2>Form Login Petugas</h2>

        <form action="proses_login.php" method="post" id="form-login">
            <div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" autocomplete="username" required>
            </div>

            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" autocomplete="current-password" required>
            </div>

            <div class="form-actions">
                <button type="submit" id="btn-login">Login</button>
            </div>

            <p class="form-link">Belum punya akun? <a href="register.php">Register di sini</a></p>
        </form>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
