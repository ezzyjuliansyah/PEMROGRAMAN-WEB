# Dokumentasi Jobsheet 7 — PHP Server-Side & Session

**Proyek:** E-Sport Championship  
**Sub-CPMK:** Menerapkan pemrosesan form dan rendering data menggunakan PHP server-side serta session.

Dokumentasi ini menjelaskan perubahan project **E-Sport Championship** dari Jobsheet 6 menuju Jobsheet 7. Pada Jobsheet 7, proses pengolahan dan penampilan data dipindahkan dari JavaScript client-side menjadi PHP server-side. Data sementara disimpan menggunakan `$_SESSION`.

## Daftar Isi

1. [Tujuan Jobsheet 7](#1-tujuan-jobsheet-7)
2. [Perubahan dari Jobsheet 6](#2-perubahan-dari-jobsheet-6)
3. [Konsep PHP Server-Side](#3-konsep-php-server-side)
4. [Session PHP](#4-session-php)
5. [Pemrosesan Form](#5-pemrosesan-form)
6. [Validasi Server-Side](#6-validasi-server-side)
7. [Flash Message](#7-flash-message)
8. [Struktur Folder](#8-struktur-folder)
9. [Alur Program](#9-alur-program)
10. [Cara Menjalankan](#10-cara-menjalankan)
11. [Pengujian](#11-pengujian)
12. [Kesimpulan](#12-kesimpulan)

---

## 1. Tujuan Jobsheet 7

Pada Jobsheet 7, project **E-Sport Championship** dikembangkan agar pengolahan data tidak lagi hanya bergantung pada JavaScript dan file JSON.

Tujuan utama yang diterapkan adalah:

- Mengubah halaman `.html` menjadi `.php`.
- Menggunakan PHP untuk memproses form di server.
- Menggunakan `$_SESSION` untuk menyimpan data sementara.
- Menampilkan data session menggunakan `foreach`.
- Menerapkan validasi pada sisi server menggunakan `$_POST`.
- Menggunakan `include` untuk header dan footer agar tidak terjadi duplikasi kode.
- Menampilkan pesan berhasil atau gagal menggunakan flash message.

---

## 2. Perubahan dari Jobsheet 6

Pada Jobsheet 6, data project **E-Sport Championship** diambil dari file JSON menggunakan JavaScript `fetch()`.

Pada Jobsheet 7, pendekatan tersebut diubah menjadi server-side PHP.

### Perubahan utama

| Jobsheet 6 | Jobsheet 7 |
|---|---|
| Halaman `.html` | Halaman `.php` |
| Data dari file JSON | Data sementara dari `$_SESSION` |
| `fetch()` untuk mengambil data | PHP mengambil data dari session |
| Rendering tabel dengan JavaScript | Rendering tabel dengan PHP `foreach` |
| Form diproses di browser | Form diproses oleh PHP server |
| Validasi JavaScript | Validasi server-side PHP |
| Header/footer dapat ditulis berulang | `includes/header.php` dan `includes/footer.php` |
| Data berada di folder `data/` | Data disimpan sementara dalam session |
| Tidak ada flash message PHP | Menggunakan `$_SESSION['flash']` |

File JavaScript khusus data dari Jobsheet 6 tidak lagi diperlukan karena proses rendering data sudah dipindahkan ke PHP.

---

## 3. Konsep PHP Server-Side

**Server-side** berarti kode PHP diproses terlebih dahulu oleh server sebelum hasil HTML dikirimkan ke browser.

Contohnya pada halaman daftar divisi:

```php
<?php foreach ($divisi as $item): ?>
    <tr>
        <td><?= htmlspecialchars($item['kode']) ?></td>
        <td><?= htmlspecialchars($item['nama_game']) ?></td>
        <td><?= htmlspecialchars($item['platform']) ?></td>
        <td><?= htmlspecialchars($item['roster']) ?></td>
    </tr>
<?php endforeach; ?>
```

Dengan pendekatan ini, browser menerima HTML yang sudah berisi data. Browser tidak perlu menjalankan `fetch()` untuk mengambil file JSON seperti pada Jobsheet 6.

---

## 4. Session PHP

Session digunakan untuk menyimpan data sementara selama session browser masih aktif.

Pada project ini session digunakan untuk menyimpan dua kelompok data:

```php
$_SESSION['divisi']
$_SESSION['anggota']
```

Contoh penyimpanan data divisi:

```php
$_SESSION['divisi'][] = $data;
```

Sebelum menggunakan session, PHP menjalankannya dengan:

```php
session_start();
```

Data session dapat digunakan kembali pada halaman lain selama session masih aktif.

> **Catatan:** Session pada Jobsheet 7 belum merupakan penyimpanan permanen. Data dapat hilang ketika session berakhir. Penyimpanan permanen ke PostgreSQL akan diterapkan pada jobsheet berikutnya.

---

## 5. Pemrosesan Form

Pada Jobsheet 7, form tambah divisi dan tambah anggota menggunakan metode `POST`.

Contoh:

```html
<form method="post" action="proses_tambah.php">
```

Ketika tombol Simpan ditekan, data dikirim ke file `proses_tambah.php`.

Data kemudian dibaca menggunakan:

```php
$_POST
```

Contoh:

```php
$namaGame = trim($_POST['nama_game'] ?? '');
$platform = trim($_POST['platform'] ?? '');
```

Setelah data lolos validasi, data dimasukkan ke session.

---

## 6. Validasi Server-Side

Validasi server-side diperlukan untuk memastikan data tetap aman dan benar meskipun JavaScript di browser tidak dijalankan.

Contoh pemeriksaan input kosong:

```php
if ($namaGame === '' || $platform === '') {
    $_SESSION['flash'] = [
        'type' => 'error',
        'message' => 'Semua data wajib diisi.'
    ];
    header('Location: tambah.php');
    exit;
}
```

Artinya, validasi tidak hanya dilakukan oleh JavaScript. Server tetap memeriksa data yang diterima melalui `$_POST`.

---

## 7. Flash Message

Flash message digunakan untuk memberikan informasi kepada pengguna setelah proses form dilakukan.

Contoh pesan berhasil:

```php
$_SESSION['flash'] = [
    'type' => 'success',
    'message' => 'Data berhasil ditambahkan.'
];
```

Setelah itu pengguna diarahkan ke halaman daftar menggunakan redirect:

```php
header('Location: list.php');
exit;
```

Header kemudian membaca `$_SESSION['flash']` dan menampilkan pesannya.

Dengan cara ini pengguna dapat mengetahui apakah proses tambah data berhasil atau gagal.

---

## 8. Struktur Folder

Struktur project Jobsheet 7 adalah:

```text
jobsheet-07/
├── anggota/
│   ├── list.php
│   ├── tambah.php
│   └── proses_tambah.php
│
├── esport/
│   ├── list.php
│   ├── tambah.php
│   └── proses_tambah.php
│
├── includes/
│   ├── header.php
│   └── footer.php
│
├── assets/
│   ├── css/
│   │   └── style.css
│   └── js/
│       └── app.js
│
├── docs/
├── Dokumentasi/
├── index.php
└── README.md
```

### Fungsi folder dan file penting

- `index.php` — halaman utama/dashboard.
- `esport/tambah.php` — form untuk menambahkan divisi game.
- `esport/proses_tambah.php` — menerima, memvalidasi, dan menyimpan data divisi ke session.
- `esport/list.php` — menampilkan daftar divisi dari session.
- `anggota/tambah.php` — form untuk menambahkan anggota.
- `anggota/proses_tambah.php` — menerima, memvalidasi, dan menyimpan data anggota ke session.
- `anggota/list.php` — menampilkan daftar anggota dari session.
- `includes/header.php` — header, navbar, session, dan pemanggilan asset bersama.
- `includes/footer.php` — footer yang digunakan bersama.
- `assets/css/style.css` — styling project.
- `assets/js/app.js` — interaksi browser seperti menu, pencarian, dan validasi awal.

---

## 9. Alur Program

### A. Menambah Divisi

```text
Tambah Divisi
     ↓
Isi Form
     ↓
POST ke proses_tambah.php
     ↓
Validasi $_POST
     ↓
Data valid?
  ↙       ↘
Tidak      Ya
 ↓          ↓
Flash      Simpan ke
error      $_SESSION['divisi']
              ↓
        Redirect ke list.php
              ↓
       Data ditampilkan
```

### B. Menambah Anggota

```text
Tambah Anggota
      ↓
Isi Form
      ↓
POST ke proses_tambah.php
      ↓
Validasi $_POST
      ↓
Data valid?
  ↙       ↘
Tidak      Ya
 ↓          ↓
Flash      Simpan ke
error      $_SESSION['anggota']
              ↓
        Redirect ke list.php
              ↓
       Data ditampilkan
```

### C. Menampilkan Data

Halaman daftar mengambil data dari session kemudian melakukan perulangan menggunakan `foreach`.

```php
foreach ($_SESSION['anggota'] as $anggota) {
    // tampilkan data anggota
}
```

Dengan demikian, proses rendering utama sudah dilakukan oleh PHP server-side.

---

## 10. Cara Menjalankan

### Opsi 1 — PHP Built-in Server

Buka terminal di dalam folder `jobsheet-07`, kemudian jalankan:

```bash
php -S localhost:8000
```

Buka browser:

```text
http://localhost:8000/index.php
```

### Opsi 2 — Laragon

Letakkan folder project di document root Laragon, misalnya:

```text
C:\laragon\www\jobsheet-07
```

Kemudian jalankan Apache melalui Laragon dan buka:

```text
http://localhost/jobsheet-07/index.php
```

---

## 11. Pengujian

Pengujian Jobsheet 7 dilakukan untuk memastikan fitur server-side berjalan dengan benar.

### Pengujian 1 — Dashboard

Buka `index.php` dan pastikan halaman utama dapat ditampilkan.

### Pengujian 2 — Tambah Divisi

1. Buka menu **Tambah Divisi**.
2. Isi seluruh data.
3. Klik **Simpan**.
4. Pastikan data tersimpan ke session.
5. Pastikan halaman diarahkan ke **Daftar Divisi**.
6. Pastikan flash message berhasil tampil.

### Pengujian 3 — Tambah Anggota

1. Buka menu **Tambah Anggota**.
2. Isi data anggota.
3. Klik **Simpan**.
4. Pastikan data masuk ke session.
5. Pastikan data muncul di **Daftar Anggota**.

### Pengujian 4 — Validasi Server

Coba kirim form tanpa mengisi data wajib.

Hasil yang diharapkan:

- Server menolak data.
- Data invalid tidak dimasukkan ke session.
- Flash message error ditampilkan.

### Pengujian 5 — JavaScript Dimatikan

Matikan JavaScript pada browser kemudian kirim data invalid.

Hasil yang diharapkan:

- Validasi PHP tetap berjalan.
- Data invalid tetap ditolak.

Hal ini membuktikan bahwa validasi server-side tidak bergantung pada JavaScript.

---

## 12. Kesimpulan

Pada Jobsheet 7, project **E-Sport Championship** mengalami perubahan dari pengolahan data menggunakan JavaScript dan JSON menjadi pengolahan data menggunakan **PHP server-side dan session**.

Konsep utama yang diterapkan adalah:

- PHP server-side.
- `$_POST` untuk menerima data form.
- `$_SESSION` untuk penyimpanan sementara.
- `foreach` untuk rendering data.
- Validasi server-side.
- Redirect setelah proses form.
- Flash message.
- `include` untuk penggunaan header dan footer bersama.

Penyimpanan data pada Jobsheet 7 masih bersifat sementara menggunakan session. Pada tahap berikutnya, data dapat dikembangkan menggunakan database PostgreSQL agar penyimpanannya bersifat permanen.
