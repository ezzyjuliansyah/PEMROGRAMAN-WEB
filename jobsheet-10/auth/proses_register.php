<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: register.php');
    exit;
}

$nama = trim($_POST['nama'] ?? '');
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

$errors = [];

if ($nama === '') {
    $errors[] = 'Nama lengkap wajib diisi.';
}
if ($username === '') {
    $errors[] = 'Username wajib diisi.';
} elseif (!preg_match('/^[A-Za-z0-9_]{3,30}$/', $username)) {
    $errors[] = 'Username 3-30 karakter, hanya huruf, angka, dan underscore.';
}
if ($password === '') {
    $errors[] = 'Password wajib diisi.';
} elseif (strlen($password) < 6) {
    $errors[] = 'Password minimal 6 karakter.';
}

if (empty($errors)) {
    // Cek username duplikat (tidak peduli huruf besar/kecil)
    $cek = $pdo->prepare('SELECT COUNT(*) FROM users WHERE LOWER(username) = LOWER(:username)');
    $cek->execute(['username' => $username]);
    if ((int) $cek->fetchColumn() > 0) {
        $errors[] = 'Username sudah digunakan.';
    }
}

if (!empty($errors)) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'message' => implode(' ', $errors)
    ];
    header('Location: register.php');
    exit;
}

// Password TIDAK disimpan polos: disimpan sebagai hash lewat password_hash()
$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare(
    'INSERT INTO users (nama, username, password)
     VALUES (:nama, :username, :password)'
);
$stmt->execute([
    'nama' => $nama,
    'username' => $username,
    'password' => $hash
]);

$_SESSION['flash'] = [
    'type' => 'success',
    'message' => 'Registrasi berhasil. Silakan login.'
];

header('Location: login.php');
exit;
