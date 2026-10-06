<?php
// Proteksi CSRF (Jobsheet 11) dengan pola "synchronizer token".
//
// Alur:
//   1. csrf_token() membuat token acak 1x per session dan menyimpannya di $_SESSION.
//   2. csrf_field() mencetak <input type="hidden"> berisi token itu di setiap form POST.
//   3. csrf_verify() dipanggil di awal setiap proses_*.php / hapus.php: token dari
//      form harus sama dengan token di session. Situs jahat tidak bisa membaca
//      token ini (beda origin), jadi form palsunya selalu ditolak (HTTP 403).

require_once __DIR__ . '/session.php';
require_once __DIR__ . '/helpers.php';

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function csrf_verify(): void
{
    $dikirim = $_POST['csrf_token'] ?? '';
    $asli = $_SESSION['csrf_token'] ?? '';

    // hash_equals = perbandingan waktu-konstan (tahan timing attack)
    if (!is_string($dikirim) || $asli === '' || !hash_equals($asli, $dikirim)) {
        http_response_code(403);
        exit('403 Forbidden - token CSRF tidak valid atau kedaluwarsa. Kembali ke halaman sebelumnya, muat ulang, lalu coba lagi.');
    }
}
