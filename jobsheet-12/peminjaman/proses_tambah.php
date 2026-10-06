<?php
$base = '../';
require __DIR__ . '/../includes/auth.php'; // guard (sekaligus memulai session)
require_once __DIR__ . '/../includes/csrf.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: tambah.php');
    exit;
}

csrf_verify();
require __DIR__ . '/../includes/koneksi.php';

$anggotaId = (int) ($_POST['anggota_id'] ?? 0);
$divisiId = (int) ($_POST['divisi_id'] ?? 0);

if ($anggotaId <= 0 || $divisiId <= 0) {
    $_SESSION['flash'] = ['type' => 'error', 'message' => 'Pilih player dan divisi terlebih dahulu.'];
    header('Location: tambah.php');
    exit;
}

// Simpan peminjaman + kurangi slot roster dalam SATU transaction:
// kalau salah satu gagal, keduanya dibatalkan (rollBack), jadi data tidak setengah-setengah.
try {
    $pdo->beginTransaction();

    // SELECT ... FOR UPDATE mengunci baris divisi sampai commit/rollBack.
    // Kalau dua peminjaman diproses hampir bersamaan, yang kedua menunggu sampai
    // yang pertama selesai, lalu membaca roster TERBARU - roster tidak bisa jadi negatif.
    $cekDivisi = $pdo->prepare('SELECT id, nama_game, roster FROM divisi WHERE id = :id FOR UPDATE');
    $cekDivisi->execute(['id' => $divisiId]);
    $divisi = $cekDivisi->fetch();

    $cekAnggota = $pdo->prepare('SELECT id, nama FROM anggota WHERE id = :id');
    $cekAnggota->execute(['id' => $anggotaId]);
    $anggota = $cekAnggota->fetch();

    if (!$divisi || !$anggota) {
        $pdo->rollBack();
        $_SESSION['flash'] = ['type' => 'error', 'message' => 'Data player atau divisi tidak ditemukan.'];
        header('Location: tambah.php');
        exit;
    }

    if ((int) $divisi['roster'] <= 0) {
        $pdo->rollBack();
        $_SESSION['flash'] = ['type' => 'error', 'message' => 'Slot roster divisi ' . $divisi['nama_game'] . ' sudah habis.'];
        header('Location: tambah.php');
        exit;
    }

    $insert = $pdo->prepare(
        "INSERT INTO peminjaman (anggota_id, divisi_id, status)
         VALUES (:anggota_id, :divisi_id, 'dipinjam')"
    );
    $insert->execute(['anggota_id' => $anggotaId, 'divisi_id' => $divisiId]);

    $kurangi = $pdo->prepare('UPDATE divisi SET roster = roster - 1 WHERE id = :id');
    $kurangi->execute(['id' => $divisiId]);

    $pdo->commit();
} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    $_SESSION['flash'] = ['type' => 'error', 'message' => 'Peminjaman gagal disimpan, silakan coba lagi.'];
    header('Location: tambah.php');
    exit;
}

$_SESSION['flash'] = [
    'type' => 'success',
    'message' => $anggota['nama'] . ' berhasil dipinjam ke divisi ' . $divisi['nama_game'] . '.'
];

header('Location: kembali.php');
exit;
