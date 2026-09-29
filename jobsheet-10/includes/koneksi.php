<?php

$databaseUrl = getenv('DATABASE_URL');

try {
    if ($databaseUrl) {
        $dbUrl = parse_url($databaseUrl);

        $host = $dbUrl['host'];
        $port = $dbUrl['port'] ?? 5432;
        $db   = ltrim($dbUrl['path'], '/');
        $user = $dbUrl['user'];
        $pass = $dbUrl['pass'];

        $pdo = new PDO(
            "pgsql:host=$host;port=$port;dbname=$db",
            $user,
            $pass
        );
    } else {
        // Konfigurasi PostgreSQL lokal
        $host = '127.0.0.1';
        $port = '5433';
        $db   = 'esport_championship';
        $user = 'postgres';
        $pass = '12345';

        $pdo = new PDO(
            "pgsql:host=$host;port=$port;dbname=$db",
            $user,
            $pass
        );
    }

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}