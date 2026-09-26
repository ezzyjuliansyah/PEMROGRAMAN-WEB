<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

// Sengaja HANYA menerima POST (bukan GET). Kalau ini menerima GET, data bisa
// terhapus tidak sengaja - misalnya kalau link "hapus.php?id=5" ke-index
// oleh crawler/bot, atau ter-klik/ter-preload oleh browser tanpa disadari
// user. Dengan mewajibkan POST lewat <form>, itu tidak bisa terjadi.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$id = (int) ($_POST['id'] ?? 0);

if ($id > 0) {
    $stmt = $pdo->prepare('DELETE FROM divisi WHERE id = :id');
    $stmt->execute(['id' => $id]);

    $_SESSION['flash'] = ['type' => 'success', 'message' => 'Data divisi berhasil dihapus.'];
} else {
    $_SESSION['flash'] = ['type' => 'error', 'message' => 'Data tidak valid.'];
}

header('Location: list.php');
exit;
