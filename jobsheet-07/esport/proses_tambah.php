<?php
session_start();

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

if (!isset($_SESSION['divisi'])) {
    $_SESSION['divisi'] = [];
}

foreach ($_SESSION['divisi'] as $divisi) {
    if (strcasecmp($divisi['kode'], $kode) === 0) {
        $errors[] = 'Kode divisi sudah digunakan.';
        break;
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

$_SESSION['divisi'][] = [
    'kode' => $kode,
    'nama_game' => $namaGame,
    'platform' => $platform,
    'roster' => (int) $roster
];

$_SESSION['flash'] = [
    'type' => 'success',
    'message' => 'Data divisi berhasil ditambahkan.'
];

header('Location: list.php');
exit;
