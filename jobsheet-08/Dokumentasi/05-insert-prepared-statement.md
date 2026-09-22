# 5. INSERT dengan Prepared Statement

Pada Jobsheet 8, data form tidak lagi dimasukkan ke array session. Data dimasukkan ke PostgreSQL menggunakan prepared statement.

Contoh pada divisi:

```php
$stmt = $pdo->prepare(
    'INSERT INTO divisi (kode, nama_game, platform, roster)
     VALUES (:kode, :nama_game, :platform, :roster)
     RETURNING id'
);
```

Kemudian parameter dikirim melalui `execute()`.

```php
$stmt->execute([
    'kode' => $kode,
    'nama_game' => $namaGame,
    'platform' => $platform,
    'roster' => (int) $roster
]);
```

`RETURNING id` membuat ID baris yang baru dimasukkan tersedia dari hasil statement dan mengikuti materi Jobsheet 8 dosen.
