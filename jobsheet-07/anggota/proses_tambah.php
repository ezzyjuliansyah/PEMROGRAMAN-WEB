<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: tambah.php');
    exit;
}

$noAnggota = trim($_POST['no_anggota'] ?? '');
$nama = trim($_POST['nama'] ?? '');
$role = trim($_POST['role'] ?? '');
$noHp = trim($_POST['no_hp'] ?? '');

$errors = [];

if ($noAnggota === '') {
    $errors[] = 'No. anggota wajib diisi.';
}

if ($nama === '') {
    $errors[] = 'Nama player wajib diisi.';
}

if ($role === '') {
    $errors[] = 'Role / posisi wajib diisi.';
}

if ($noHp === '') {
    $errors[] = 'No. HP wajib diisi.';
} elseif (!preg_match('/^08\d{8,13}$/', $noHp)) {
    $errors[] = 'No. HP harus berupa angka dan diawali 08.';
}

if (!isset($_SESSION['anggota'])) {
    $_SESSION['anggota'] = [];
}

foreach ($_SESSION['anggota'] as $anggota) {
    if (strcasecmp($anggota['no_anggota'], $noAnggota) === 0) {
        $errors[] = 'No. anggota sudah digunakan.';
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

$_SESSION['anggota'][] = [
    'no_anggota' => $noAnggota,
    'nama' => $nama,
    'role' => $role,
    'no_hp' => $noHp
];

$_SESSION['flash'] = [
    'type' => 'success',
    'message' => 'Data anggota berhasil ditambahkan.'
];

header('Location: list.php');
exit;
