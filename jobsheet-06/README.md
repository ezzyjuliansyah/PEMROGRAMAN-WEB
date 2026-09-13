# Jobsheet 6 — Fetch API & JSON

**Proyek:** E-Sport Championship
**Sub-CPMK:** Menerapkan komunikasi asinkron (AJAX/fetch, JSON).

## Perubahan dari Jobsheet 5

- Tambah `data/divisi.json` (5 objek) dan `data/anggota.json` (3 objek) sebagai pengganti sementara API sungguhan.
- `esport/list.html` & `anggota/list.html`: `<tbody>` dikosongkan, baris kini dirender dinamis oleh `assets/js/esport.js` / `assets/js/anggota.js` menggunakan `fetch` + `async/await`.
- Loading indicator (`#loading-indicator`) tampil selama proses fetch (disimulasikan dengan delay 600ms).
- Penanganan error (`try/catch`) menampilkan pesan di dalam tabel bila fetch gagal.
- `app.js`: konfirmasi hapus diubah ke **event delegation** (`document.addEventListener("click", ...)`) karena tombol Hapus sekarang berada di baris yang dibuat setelah halaman selesai dimuat.

## Struktur Folder

```text
jobsheet-06/
├── anggota/
│   ├── list.html
│   └── tambah.html
├── assets/
│   ├── css/
│   │   └── style.css
│   └── js/
│       ├── app.js
│       ├── esport.js
│       └── anggota.js
├── data/
│   ├── divisi.json
│   └── anggota.json
├── esport/
│   ├── list.html
│   └── tambah.html
├── index.html
├── Dokumentasi/
└── README.md
```

## Cara Menjalankan

**Penting:** `fetch()` ke file lokal akan diblokir kebijakan CORS jika dibuka langsung dengan `file://`. Jalankan lewat server lokal, misalnya:

```
php -S localhost:8000
```

lalu buka `http://localhost:8000/index.html`. Bisa juga memakai ekstensi "Live Server" di VSCode.

Setelah itu:

1. Buka halaman Daftar Divisi atau Daftar Anggota — perhatikan pesan "⏳ Memuat data..." muncul sebentar sebelum data tampil.
2. Gunakan kotak pencarian untuk memfilter data yang sudah dimuat.
3. Klik tombol Hapus dan uji konfirmasinya.
4. Buka halaman Tambah Divisi/Anggota — validasi form masih berfungsi seperti Jobsheet 5.

## Catatan

- Uji error handling dengan mengganti sementara nama file di `fetch(...)` menjadi nama yang salah (misalnya `divisii.json`), lalu refresh — pesan error merah harus muncul di dalam tabel.
- Pola `fetch` + `async/await` di sini akan dipakai ulang untuk memanggil endpoint PHP sungguhan mulai Jobsheet 9 (setelah back-end PostgreSQL siap di Jobsheet 8), meskipun mulai Jobsheet 7 rendering utama berpindah ke server-side PHP.
