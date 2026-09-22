<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

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

if (empty($errors)) {
    $cek = $pdo->prepare('SELECT COUNT(*) FROM anggota WHERE LOWER(no_anggota) = LOWER(:no_anggota)');
    $cek->execute(['no_anggota' => $noAnggota]);
    if ((int) $cek->fetchColumn() > 0) {
        $errors[] = 'No. anggota sudah digunakan.';
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
    'INSERT INTO anggota (no_anggota, nama, role, no_hp)
     VALUES (:no_anggota, :nama, :role, :no_hp)
     RETURNING id'
);
$stmt->execute([
    'no_anggota' => $noAnggota,
    'nama' => $nama,
    'role' => $role,
    'no_hp' => $noHp
]);

$_SESSION['flash'] = [
    'type' => 'success',
    'message' => 'Data anggota berhasil ditambahkan.'
];

header('Location: list.php');
exit;
