# 6. Membaca Data dengan SELECT

Halaman daftar mengambil data langsung dari PostgreSQL.

Contoh:

```php
$daftarDivisi = $pdo->query(
    'SELECT * FROM divisi ORDER BY id DESC'
)->fetchAll();
```

Data kemudian dirender menggunakan `foreach`.

```php
foreach ($daftarDivisi as $divisi) {
    // tampilkan data
}
```

Dashboard menggunakan:

```php
$pdo->query('SELECT COUNT(*) FROM divisi')->fetchColumn();
```

Dengan cara ini jumlah data pada dashboard selalu mengikuti isi database.
