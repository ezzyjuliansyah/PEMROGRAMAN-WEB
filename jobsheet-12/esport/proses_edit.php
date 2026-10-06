<?php
$base = '../';
require __DIR__ . '/../includes/auth.php'; // guard (sekaligus memulai session)
require_once __DIR__ . '/../includes/csrf.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

// Jobsheet 11: tolak request tanpa token CSRF yang valid SEBELUM menyentuh database
csrf_verify();
require __DIR__ . '/../includes/koneksi.php';

$id = (int) ($_POST['id'] ?? 0);
$kode = trim($_POST['kode_divisi'] ?? '');
$namaGame = trim($_POST['nama_game'] ?? '');
$platform = trim($_POST['platform'] ?? '');
$roster = trim($_POST['roster'] ?? '');

$errors = [];

if ($id <= 0) {
    $errors[] = 'Data tidak valid.';
}
if ($kode === '') {
    $errors[] = 'Kode divisi wajib diisi.';
}
if ($namaGame === '') {
    $errors[] = 'Nama game wajib diisi.';
}
if ($platform === '') {
    $errors[] = 'Platform wajib diisi.';
}
if ($roster === '' || !ctype_digit($roster) || (int) $roster < 0) {
    $errors[] = 'Jumlah roster harus berupa angka minimal 0.';
}

if (empty($errors)) {
    // Cek duplikat kode, TAPI kecualikan baris ini sendiri (AND id != :id)
    // - beda dari proses_tambah.php karena di sini kode boleh sama dengan
    // punya dirinya sendiri (user tidak mengubah kodenya).
    $cek = $pdo->prepare('SELECT COUNT(*) FROM divisi WHERE LOWER(kode) = LOWER(:kode) AND id != :id');
    $cek->execute(['kode' => $kode, 'id' => $id]);
    if ((int) $cek->fetchColumn() > 0) {
        $errors[] = 'Kode divisi sudah digunakan oleh data lain.';
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
    'UPDATE divisi
     SET kode = :kode, nama_game = :nama_game, platform = :platform, roster = :roster
     WHERE id = :id'
);
$stmt->execute([
    'kode' => $kode,
    'nama_game' => $namaGame,
    'platform' => $platform,
    'roster' => (int) $roster,
    'id' => $id,
]);

$_SESSION['flash'] = [
    'type' => 'success',
    'message' => 'Data divisi berhasil diperbarui.'
];

header('Location: list.php');
exit;
