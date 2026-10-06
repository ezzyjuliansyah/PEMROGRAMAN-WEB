<?php
$base = '../';
require __DIR__ . '/../includes/auth.php'; // guard (sekaligus memulai session)
require_once __DIR__ . '/../includes/csrf.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: kembali.php');
    exit;
}

csrf_verify();
require __DIR__ . '/../includes/koneksi.php';

$id = (int) ($_POST['id'] ?? 0);

if ($id <= 0) {
    $_SESSION['flash'] = ['type' => 'error', 'message' => 'Data tidak valid.'];
    header('Location: kembali.php');
    exit;
}

// Ubah status jadi 'selesai' + tambah kembali slot roster dalam SATU transaction.
try {
    $pdo->beginTransaction();

    // Kunci baris peminjaman: kalau tombol Kembalikan terklik dua kali / dari dua tab,
    // yang kedua melihat status sudah 'selesai' dan tidak menambah roster dua kali.
    $cek = $pdo->prepare('SELECT id, divisi_id, status FROM peminjaman WHERE id = :id FOR UPDATE');
    $cek->execute(['id' => $id]);
    $pinjam = $cek->fetch();

    if (!$pinjam || $pinjam['status'] !== 'dipinjam') {
        $pdo->rollBack();
        $_SESSION['flash'] = ['type' => 'error', 'message' => 'Peminjaman tidak ditemukan atau sudah dikembalikan.'];
        header('Location: kembali.php');
        exit;
    }

    $tutup = $pdo->prepare("UPDATE peminjaman SET status = 'selesai', tgl_kembali = NOW() WHERE id = :id");
    $tutup->execute(['id' => $id]);

    $tambah = $pdo->prepare('UPDATE divisi SET roster = roster + 1 WHERE id = :id');
    $tambah->execute(['id' => (int) $pinjam['divisi_id']]);

    $pdo->commit();
} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    $_SESSION['flash'] = ['type' => 'error', 'message' => 'Pengembalian gagal diproses, silakan coba lagi.'];
    header('Location: kembali.php');
    exit;
}

$_SESSION['flash'] = ['type' => 'success', 'message' => 'Player berhasil dikembalikan, slot roster divisi bertambah.'];

header('Location: kembali.php');
exit;
