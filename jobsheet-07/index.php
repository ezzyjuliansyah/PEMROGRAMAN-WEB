<?php
$base = '';
$pageTitle = 'E-Sport Championship';
$activePage = 'home';
include 'includes/header.php';

$totalDivisi = count($_SESSION['divisi']);
$totalAnggota = count($_SESSION['anggota']);
?>

<main>
    <div class="content-card">
        <h2>Dashboard</h2>
        <p class="welcome-text">
            Selamat datang di Web Pengelola Data Divisi &amp; Anggota E-Sport Championship.
        </p>

        <h3 class="stat-section-title">Statistik Divisi &amp; Anggota</h3>

        <div class="stat-grid">
            <div class="stat-box">
                <div class="stat-label">Total Divisi Game</div>
                <div class="stat-value"><?= $totalDivisi ?> Divisi</div>
            </div>

            <div class="stat-box">
                <div class="stat-label">Total Anggota Player</div>
                <div class="stat-value"><?= $totalAnggota ?> Player</div>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
