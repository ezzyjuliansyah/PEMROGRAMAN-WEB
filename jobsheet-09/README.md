# Jobsheet 9 — CRUD Penuh

**Proyek:** E-Sport Championship
**Sub-CPMK:** Membangun fitur CRUD pada proyek.

## Perubahan dari Jobsheet 8

- Tambah `esport/edit.php` + `esport/proses_edit.php`, `anggota/edit.php` + `anggota/proses_edit.php` — melengkapi Create+Read (Jobsheet 8) dengan **Update**.
- Tambah `esport/hapus.php`, `anggota/hapus.php` — **Delete**, hanya menerima `POST` (bukan GET) agar tidak terpicu tidak sengaja lewat link/crawler.
- Tombol Hapus di `list.php` sekarang berupa `<form class="form-hapus" method="post">` sungguhan (bukan lagi tombol `<button>` polos) — `app.js` (`initHapusConfirm`) diubah untuk konfirmasi di event `submit` (bisa `preventDefault()`), bukan `click`.
- `esport/list.php` & `anggota/list.php`: tambah **pagination** (`LIMIT`/`OFFSET`, 5 baris/halaman) dan **pencarian server-side** (`WHERE ... ILIKE :kw`) — form GET, menggantikan kolom cari client-side murni dari Jobsheet 5/6/7.

## Struktur Folder

```text
jobsheet-09/
├── includes/
│   ├── header.php
│   ├── footer.php
│   └── koneksi.php
├── esport/
│   ├── list.php
│   ├── tambah.php
│   ├── proses_tambah.php
│   ├── edit.php
│   ├── proses_edit.php
│   └── hapus.php
├── anggota/
│   ├── list.php
│   ├── tambah.php
│   ├── proses_tambah.php
│   ├── edit.php
│   ├── proses_edit.php
│   └── hapus.php
├── assets/
│   ├── css/style.css
│   └── js/app.js
├── sql/
│   └── 01_divisi_anggota.sql
├── index.php
└── README.md
```

Tidak ada perubahan skema tabel dari Jobsheet 8 — `sql/01_divisi_anggota.sql` sama persis, cukup pakai database yang sudah ada.

## Cara Menjalankan

**Opsi 1 — PHP built-in server:**

```
php -S localhost:8000
```

Buka `http://localhost:8000/index.php`, uji siklus lengkap: tambah → tampil → ubah (Edit) → tampil berubah → hapus → hilang dari list.

**Opsi 2 — Laragon (Apache):** lewat virtual host langsung ke folder `jobsheet-09/` (mis. `http://jobsheet09.test/`), atau bersarang di bawah domain proyek (mis. `http://dp2026.test/kode-praktikum/jobsheet-09/`) — path CSS/JS/link sudah relatif otomatis (lihat `includes/header.php`), jadi keduanya jalan.

## Catatan

- Kolom pencarian (`#search-input`) di halaman ini melayani dua peran: filter instan client-side (JS, dari Jobsheet 5) untuk baris yang sedang tampil di halaman saat ini, dan pencarian penuh lintas-halaman lewat tombol "Cari" (server-side).
- Nilai `q` dari pencarian belum di-escape saat ditampilkan kembali ke `value` input — ini **sengaja** belum diperbaiki di sini; audit dan perbaikan XSS dilakukan menyeluruh di Jobsheet 11.
