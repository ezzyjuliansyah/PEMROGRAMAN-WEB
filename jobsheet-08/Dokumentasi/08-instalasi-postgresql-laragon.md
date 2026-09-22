# 8. PostgreSQL pada Laragon

Jobsheet 8 membutuhkan PostgreSQL dan ekstensi PHP `pdo_pgsql`.

## Pemeriksaan ekstensi

Di terminal PHP, jalankan:

```bash
php -m
```

Pastikan terdapat:

```text
pdo_pgsql
pgsql
```

Jika ekstensi belum aktif, periksa `php.ini` dan aktifkan ekstensi PostgreSQL yang tersedia pada instalasi PHP, lalu restart server.

## Koneksi aplikasi

Sesuaikan:

```php
$host = 'localhost';
$port = '5432';
$db   = 'esport_championship';
$user = 'postgres';
$pass = 'postgres';
```

Password di atas hanya contoh. Gunakan password PostgreSQL yang benar pada komputer masing-masing.
