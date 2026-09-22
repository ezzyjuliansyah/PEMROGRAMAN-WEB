<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$base = $base ?? '';
$pageTitle = $pageTitle ?? 'E-Sport Championship';
$activePage = $activePage ?? '';

function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= e($pageTitle) ?></title>
    <link rel="stylesheet" href="<?= $base ?>assets/css/style.css">
</head>
<body>
    <header class="site-header">
        <h1>E-Sport Championship</h1>
        <p class="site-subtitle">Web Pengelola Data Divisi &amp; Anggota E-Sport</p>
    </header>

    <button type="button" class="nav-toggle-label" aria-label="Buka menu" aria-expanded="false">☰</button>

    <nav class="site-nav">
        <ul>
            <li><a href="<?= $base ?>index.php" class="<?= $activePage === 'home' ? 'active' : '' ?>">Beranda</a></li>
            <li><a href="<?= $base ?>esport/list.php" class="<?= $activePage === 'divisi-list' ? 'active' : '' ?>">Daftar Divisi</a></li>
            <li><a href="<?= $base ?>esport/tambah.php" class="<?= $activePage === 'divisi-tambah' ? 'active' : '' ?>">Tambah Divisi</a></li>
            <li><a href="<?= $base ?>anggota/list.php" class="<?= $activePage === 'anggota-list' ? 'active' : '' ?>">Daftar Anggota</a></li>
            <li><a href="<?= $base ?>anggota/tambah.php" class="<?= $activePage === 'anggota-tambah' ? 'active' : '' ?>">Tambah Anggota</a></li>
        </ul>
    </nav>

    <?php if (isset($_SESSION['flash'])): ?>
        <div class="flash-message <?= e($_SESSION['flash']['type']) ?>">
            <?= e($_SESSION['flash']['message']) ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>
