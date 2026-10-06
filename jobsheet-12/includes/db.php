<?php
// Pembuat koneksi PostgreSQL yang dipakai bersama (halaman + penyimpan session).
// Semua setting dibaca dari environment variable; kalau tidak ada, dipakai
// nilai lokal (Laragon/PostgreSQL di komputer sendiri) seperti Jobsheet 8-10.
//
// Di Vercel + Supabase, isi variabel ini di Project Settings > Environment Variables:
//   DB_HOST, DB_PORT, DB_NAME, DB_USER, DB_PASS, DB_SSLMODE, DB_EMULATE_PREPARES

function buatKoneksi(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $host = getenv('DB_HOST') ?: '127.0.0.1';
    $port = getenv('DB_PORT') ?: '5433';
    $db   = getenv('DB_NAME') ?: 'esport_championship';
    $user = getenv('DB_USER') ?: 'postgres';
    $pass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : '12345';
    $ssl  = getenv('DB_SSLMODE') ?: 'prefer';

    $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

    // Supabase transaction pooler (port 6543) tidak mendukung prepared statement
    // di sisi server, jadi PDO diminta menyiapkan query di sisi PHP.
    if (getenv('DB_EMULATE_PREPARES') === '1') {
        $options[PDO::ATTR_EMULATE_PREPARES] = true;
    }

    $pdo = new PDO(
        "pgsql:host=$host;port=$port;dbname=$db;sslmode=$ssl",
        $user,
        $pass,
        $options
    );

    return $pdo;
}
