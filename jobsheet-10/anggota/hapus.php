<?php
$base = '../';
require __DIR__ . '/../includes/auth.php'; // guard (sekaligus memulai session)
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$id = (int) ($_POST['id'] ?? 0);

if ($id > 0) {
    $stmt = $pdo->prepare('DELETE FROM anggota WHERE id = :id');
    $stmt->execute(['id' => $id]);

    $_SESSION['flash'] = ['type' => 'success', 'message' => 'Data anggota berhasil dihapus.'];
} else {
    $_SESSION['flash'] = ['type' => 'error', 'message' => 'Data tidak valid.'];
}

header('Location: list.php');
exit;
