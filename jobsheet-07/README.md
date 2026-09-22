# Jobsheet 7 — PHP Server-Side & Session

**Proyek:** E-Sport Championship  
**Sub-CPMK:** Menerapkan pemrosesan form dan rendering data menggunakan PHP server-side.

## Perubahan dari Jobsheet 6

- Semua halaman `.html` diubah menjadi `.php`.
- Ditambahkan `includes/header.php` dan `includes/footer.php` agar header, navbar, footer, dan pemanggilan CSS/JS tidak ditulis berulang.
- Path CSS, JS, dan link menggunakan `$base` relatif terhadap root proyek.
- `esport/tambah.php` dan `anggota/tambah.php` menggunakan `method="post"` dan mengarah ke `proses_tambah.php`.
- `esport/proses_tambah.php` dan `anggota/proses_tambah.php` melakukan validasi `$_POST` di server.
- Data hasil form disimpan ke `$_SESSION['divisi']` dan `$_SESSION['anggota']`.
- Setelah berhasil, halaman proses melakukan redirect ke halaman daftar.
- `esport/list.php` dan `anggota/list.php` menampilkan data session menggunakan `foreach`.
- Pesan berhasil/gagal ditampilkan menggunakan `$_SESSION['flash']`.
- `assets/js/esport.js`, `assets/js/anggota.js`, dan folder `data/` dari Jobsheet 6 dihapus karena rendering sudah dipindahkan ke server-side PHP.
- `assets/js/app.js` tetap dipakai untuk hamburger menu, pencarian tabel, dan validasi awal di browser. Validasi server tetap berjalan meskipun JavaScript dimatikan.

## Struktur Folder

```text
jobsheet-07/
├── anggota/
│   ├── list.php
│   ├── tambah.php
│   └── proses_tambah.php
├── assets/
│   ├── css/
│   │   └── style.css
│   └── js/
│       └── app.js
├── docs/
├── Dokumentasi/
├── esport/
│   ├── list.php
│   ├── tambah.php
│   └── proses_tambah.php
├── includes/
│   ├── header.php
│   └── footer.php
├── index.php
└── README.md
```

## Cara Menjalankan

### Opsi 1 — PHP Built-in Server

Buka terminal di dalam folder `jobsheet-07`, kemudian jalankan:

```bash
php -S localhost:8000
```

Setelah itu buka:

```text
http://localhost:8000/index.php
```

### Opsi 2 — Laragon

Letakkan folder `jobsheet-07` di document root Laragon. Contoh:

```text
C:\laragon\www\jobsheet-07
```

Kemudian buka melalui virtual host atau:

```text
http://localhost/jobsheet-07/index.php
```

## Pengujian Jobsheet 7

1. Buka Dashboard.
2. Buka **Tambah Divisi**, isi data lengkap, lalu klik Simpan.
3. Setelah berhasil, sistem redirect ke **Daftar Divisi** dan menampilkan flash message.
4. Tambahkan anggota melalui **Tambah Anggota**.
5. Periksa **Daftar Anggota**; data ditampilkan menggunakan `foreach` dari session.
6. Coba kirim form kosong atau data tidak valid. Server harus menolak dan menampilkan flash message error.
7. Matikan JavaScript di browser lalu kirim data invalid. Data tetap harus ditolak karena validasi server dilakukan di PHP.
8. Refresh halaman daftar. Data session tetap ada selama session browser belum berakhir.

## Catatan

Data awal dari Jobsheet 6 dimasukkan satu kali ke session agar tampilan tidak langsung kosong setelah folder `data/` dihapus. Setelah itu, data tambahan disimpan ke session.

Sesuai Jobsheet 7, penyimpanan ini masih bersifat sementara. Data belum disimpan permanen ke database; penyimpanan PostgreSQL akan dikerjakan pada jobsheet berikutnya.
