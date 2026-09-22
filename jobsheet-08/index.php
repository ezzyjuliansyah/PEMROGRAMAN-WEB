<?php
$base = '';
$pageTitle = 'E-Sport Championship';
$activePage = 'home';
include __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/koneksi.php';

$totalDivisi = $pdo->query('SELECT COUNT(*) FROM divisi')->fetchColumn();
$totalAnggota = $pdo->query('SELECT COUNT(*) FROM anggota')->fetchColumn();
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
                <div class="stat-value"><?= e($totalDivisi) ?> Divisi</div>
            </div>

            <div class="stat-box">
                <div class="stat-label">Total Anggota Player</div>
                <div class="stat-value"><?= e($totalAnggota) ?> Player</div>
            </div>
        </div>
    </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
