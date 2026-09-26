<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: tambah.php');
    exit;
}

$kode = trim($_POST['kode_divisi'] ?? '');
$namaGame = trim($_POST['nama_game'] ?? '');
$platform = trim($_POST['platform'] ?? '');
$roster = trim($_POST['roster'] ?? '');

$errors = [];

if ($kode === '') {
    $errors[] = 'Kode divisi wajib diisi.';
}
if ($namaGame === '') {
    $errors[] = 'Nama game wajib diisi.';
}
if ($platform === '') {
    $errors[] = 'Platform wajib diisi.';
}
if ($roster === '' || !ctype_digit($roster) || (int) $roster < 1) {
    $errors[] = 'Jumlah roster harus berupa angka minimal 1.';
}

if (empty($errors)) {
    $cek = $pdo->prepare('SELECT COUNT(*) FROM divisi WHERE LOWER(kode) = LOWER(:kode)');
    $cek->execute(['kode' => $kode]);
    if ((int) $cek->fetchColumn() > 0) {
        $errors[] = 'Kode divisi sudah digunakan.';
    }
}

if (!empty($errors)) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'message' => implode(' ', $errors)
    ];
    header('Location: tambah.php');
    exit;
}

$stmt = $pdo->prepare(
    'INSERT INTO divisi (kode, nama_game, platform, roster)
     VALUES (:kode, :nama_game, :platform, :roster)
     RETURNING id'
);
$stmt->execute([
    'kode' => $kode,
    'nama_game' => $namaGame,
    'platform' => $platform,
    'roster' => (int) $roster
]);

$_SESSION['flash'] = [
    'type' => 'success',
    'message' => 'Data divisi berhasil ditambahkan.'
];

header('Location: list.php');
exit;
