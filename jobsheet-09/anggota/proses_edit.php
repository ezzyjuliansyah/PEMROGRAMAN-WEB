<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$id = (int) ($_POST['id'] ?? 0);
$noAnggota = trim($_POST['no_anggota'] ?? '');
$nama = trim($_POST['nama'] ?? '');
$role = trim($_POST['role'] ?? '');
$noHp = trim($_POST['no_hp'] ?? '');

$errors = [];

if ($id <= 0) {
    $errors[] = 'Data tidak valid.';
}
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
    $cek = $pdo->prepare('SELECT COUNT(*) FROM anggota WHERE LOWER(no_anggota) = LOWER(:no_anggota) AND id != :id');
    $cek->execute(['no_anggota' => $noAnggota, 'id' => $id]);
    if ((int) $cek->fetchColumn() > 0) {
        $errors[] = 'No. anggota sudah digunakan oleh data lain.';
    }
}

if (!empty($errors)) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'message' => implode(' ', $errors)
    ];
    header('Location: edit.php?id=' . $id);
    exit;
}

$stmt = $pdo->prepare(
    'UPDATE anggota
     SET no_anggota = :no_anggota, nama = :nama, role = :role, no_hp = :no_hp
     WHERE id = :id'
);
$stmt->execute([
    'no_anggota' => $noAnggota,
    'nama' => $nama,
    'role' => $role,
    'no_hp' => $noHp,
    'id' => $id,
]);

$_SESSION['flash'] = [
    'type' => 'success',
    'message' => 'Data anggota berhasil diperbarui.'
];

header('Location: list.php');
exit;
