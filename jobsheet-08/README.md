# Jobsheet 8 — Koneksi PostgreSQL & PDO

**Proyek:** E-Sport Championship  
**Sub-CPMK:** Menghubungkan aplikasi PHP dengan basis data PostgreSQL menggunakan PDO.

## Perubahan dari Jobsheet 7

Jobsheet 8 mempertahankan tema dan antarmuka **E-Sport Championship** dari Jobsheet 7, tetapi mengubah penyimpanan data dari `$_SESSION` menjadi database PostgreSQL.

Perubahan utama:

- Menambahkan `sql/01_divisi_anggota.sql` untuk membuat tabel `divisi` dan `anggota`.
- Menambahkan `includes/koneksi.php` untuk koneksi PDO dengan driver `pgsql`.
- `esport/proses_tambah.php` dan `anggota/proses_tambah.php` menggunakan prepared statement `INSERT ... RETURNING id`.
- `esport/list.php` dan `anggota/list.php` mengambil data dengan `SELECT * ... ORDER BY id DESC`.
- `index.php` mengambil jumlah data menggunakan `SELECT COUNT(*)`.
- `$_SESSION` tetap dipakai hanya untuk session dan flash message, bukan sebagai penyimpanan data utama.
- Data yang tersimpan di PostgreSQL tetap ada setelah browser ditutup atau session berakhir.

## Struktur Folder

```text
jobsheet-08/
├── anggota/
│   ├── list.php
│   ├── tambah.php
│   └── proses_tambah.php
├── assets/
│   ├── css/style.css
│   └── js/app.js
├── docs/
│   └── wireframe.md
├── Dokumentasi/
│   ├── README.md
│   ├── 01-konsep-dasar-database-sql.md
│   ├── 02-skema-database-sql.md
│   ├── 03-persiapan-database.md
│   ├── 04-koneksi-pdo.md
│   ├── 05-insert-prepared-statement.md
│   ├── 06-membaca-data-select.md
│   ├── 07-rangkuman-latihan.md
│   └── 08-instalasi-postgresql-laragon.md
├── esport/
│   ├── list.php
│   ├── tambah.php
│   └── proses_tambah.php
├── includes/
│   ├── header.php
│   ├── footer.php
│   └── koneksi.php
├── sql/
│   └── 01_divisi_anggota.sql
├── index.php
└── README.md
```

## Persiapan PostgreSQL

1. Pastikan PostgreSQL berjalan.
2. Pastikan ekstensi PHP `pdo_pgsql` aktif. Cek dengan `php -m` dan cari `pdo_pgsql`.
3. Buat database, misalnya:

```sql
CREATE DATABASE esport_championship;
```

4. Jalankan file `sql/01_divisi_anggota.sql` pada database tersebut.
5. Sesuaikan `$user` dan `$pass` pada `includes/koneksi.php` dengan PostgreSQL lokal.

## Cara Menjalankan

### Laragon

Letakkan folder project di document root Laragon atau buat virtual host yang mengarah ke folder `jobsheet-08`.

Contoh URL:

```text
http://localhost/jobsheet-08/index.php
```

### PHP Built-in Server

Buka terminal pada folder `jobsheet-08`, lalu:

```bash
php -S localhost:8000
```

Buka `http://localhost:8000/index.php`.

## Pengujian

- Dashboard membaca jumlah divisi dan anggota dari PostgreSQL.
- Tambah Divisi menyimpan data menggunakan prepared statement.
- Tambah Anggota menyimpan data menggunakan prepared statement.
- Daftar Divisi membaca data menggunakan `SELECT`.
- Daftar Anggota membaca data menggunakan `SELECT`.
- Data tetap tersedia setelah browser ditutup karena tersimpan di database.
- Validasi server tetap dilakukan di PHP.
