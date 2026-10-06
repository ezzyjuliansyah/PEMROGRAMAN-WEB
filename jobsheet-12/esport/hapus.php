<?php
$base = '../';
require __DIR__ . '/../includes/auth.php'; // guard (sekaligus memulai session)
require_once __DIR__ . '/../includes/csrf.php';

// Sengaja HANYA menerima POST (bukan GET). Kalau ini menerima GET, data bisa
// terhapus tidak sengaja - misalnya kalau link "hapus.php?id=5" ke-index
// oleh crawler/bot, atau ter-klik/ter-preload oleh browser tanpa disadari
// user. Dengan mewajibkan POST lewat <form>, itu tidak bisa terjadi.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

// Jobsheet 11: tolak request tanpa token CSRF yang valid SEBELUM menyentuh database
csrf_verify();
require __DIR__ . '/../includes/koneksi.php';

$id = (int) ($_POST['id'] ?? 0);

if ($id > 0) {
    try {
        $stmt = $pdo->prepare('DELETE FROM divisi WHERE id = :id');
        $stmt->execute(['id' => $id]);

        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Data divisi berhasil dihapus.'];
    } catch (PDOException $e) {
        // 23503 = foreign key violation: data masih dipakai tabel peminjaman (Jobsheet 12)
        if ($e->getCode() === '23503') {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Data divisi tidak bisa dihapus karena masih punya riwayat peminjaman.'];
        } else {
            throw $e;
        }
    }
} else {
    $_SESSION['flash'] = ['type' => 'error', 'message' => 'Data tidak valid.'];
}

header('Location: list.php');
exit;
