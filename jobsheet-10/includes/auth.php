<?php
// Guard clause Jobsheet 10.
// WAJIB di-include sebagai baris pertama (sebelum header.php) di setiap
// halaman yang dikunci, supaya header('Location: ...') masih bisa dipanggil
// sebelum ada output HTML.
//
// File ini sengaja TIDAK memanggil koneksi.php: guard berjalan sebelum kode
// yang butuh koneksi database, jadi halaman terkunci tetap redirect ke Login
// meski database belum tersambung.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// $base diisi oleh halaman pemanggil ('../' untuk halaman di dalam subfolder),
// jadi redirect ke Login otomatis relatif terhadap posisi halaman.
$base = $base ?? '';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'message' => 'Silakan login terlebih dahulu.'
    ];
    header('Location: ' . $base . 'auth/login.php');
    exit;
}
