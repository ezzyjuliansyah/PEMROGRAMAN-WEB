<?php

require_once __DIR__ . '/db.php';

try {
    $pdo = buatKoneksi();
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
