<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/csrf.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

// Jobsheet 11: tolak request tanpa token CSRF yang valid SEBELUM menyentuh database
csrf_verify();
require __DIR__ . '/../includes/koneksi.php';

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
    $_SESSION['flash'] = [
        'type' => 'error',
        'message' => 'Username dan password wajib diisi.'
    ];
    header('Location: login.php');
    exit;
}

$stmt = $pdo->prepare('SELECT id, nama, username, password, role FROM users WHERE LOWER(username) = LOWER(:username)');
$stmt->execute(['username' => $username]);
$user = $stmt->fetch();

// password_verify() membandingkan input dengan hash di database.
// Pesan gagal sengaja dibuat sama (username salah / password salah)
// supaya tidak membocorkan username mana yang terdaftar.
if (!$user || !password_verify($password, $user['password'])) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'message' => 'Username atau password salah.'
    ];
    header('Location: login.php');
    exit;
}

// Ganti ID session setelah login berhasil (mencegah session fixation)
session_regenerate_id(true);

// Jobsheet 11: token CSRF ikut diganti setelah login (token sesi tamu tidak dipakai lagi)
unset($_SESSION['csrf_token']);

$_SESSION['user_id'] = (int) $user['id'];
$_SESSION['user_nama'] = $user['nama'];
$_SESSION['user_role'] = $user['role'];
$_SESSION['flash'] = [
    'type' => 'success',
    'message' => 'Login berhasil. Selamat datang, ' . $user['nama'] . '.'
];

header('Location: ../index.php');
exit;
