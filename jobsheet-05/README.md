# Jobsheet 5 — JavaScript DOM & Event

**Proyek:** E-Sport Championship  
**Sub-CPMK:** Menerapkan JavaScript untuk manipulasi DOM dan event pada halaman web.

## Lanjutan dari Jobsheet 4

Jobsheet 5 menggunakan project **E-Sport Championship** dari Jobsheet 4. Tema dan struktur data tetap dipertahankan; fitur baru ditambahkan menggunakan JavaScript.

## Struktur Folder

```text
jobsheet-05/
├── anggota/
│   ├── list.html
│   └── tambah.html
├── assets/
│   ├── css/
│   │   └── style.css
│   └── js/
│       └── app.js
├── docs/
│   └── wireframe.md
├── Dokumentasi/
├── esport/
│   ├── list.html
│   └── tambah.html
├── index.html
├── infografis.png
├── README.md
└── README_JS4_BACKUP.md
```

## Fitur Jobsheet 5

### 1. Menu Hamburger

Pada tampilan mobile, tombol `☰` dikendalikan oleh JavaScript. Event `click` menambahkan atau menghapus class `nav-open` pada elemen `nav`.

### 2. Validasi Form

Form tambah anggota dan tambah divisi divalidasi menggunakan event `submit`. Pesan kesalahan dibuat secara dinamis menggunakan DOM jika input belum sesuai.

### 3. Filter Tabel Real-Time

Input pencarian menggunakan event `input`. Setiap baris tabel diperiksa berdasarkan teksnya sehingga baris yang tidak sesuai kata kunci disembunyikan tanpa reload halaman.

### 4. Konfirmasi Hapus

Tombol hapus menggunakan `confirm()`. Jika pengguna memilih OK, baris `<tr>` dihapus dari DOM menggunakan `row.remove()`.

> Catatan: penghapusan pada Jobsheet 5 hanya menghilangkan data dari tampilan browser. Data belum dihapus dari database karena backend/database belum digunakan.

## Cara Menjalankan

Buka `index.html` menggunakan browser, lalu coba:

1. Buka halaman Daftar Divisi atau Daftar Anggota.
2. Gunakan kotak pencarian dan ketik kata kunci.
3. Klik tombol Hapus dan uji konfirmasi.
4. Buka halaman Tambah Divisi atau Tambah Anggota.
5. Klik Simpan saat beberapa input kosong untuk melihat validasi.
6. Buka website pada ukuran layar mobile untuk menguji menu hamburger.

## File Utama

- `assets/js/app.js` — seluruh JavaScript DOM dan Event.
- `assets/css/style.css` — styling halaman dan komponen interaktif.
- `anggota/list.html` — tabel anggota + filter + hapus.
- `anggota/tambah.html` — form anggota + validasi.
- `esport/list.html` — tabel divisi + filter + hapus.
- `esport/tambah.html` — form divisi + validasi.
