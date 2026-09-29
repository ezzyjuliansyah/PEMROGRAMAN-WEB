# Jobsheet 10 — Autentikasi (Register, Login, Logout)

**Proyek:** E-Sport Championship
**Sub-CPMK:** Membangun autentikasi pengguna dan membatasi akses halaman dengan session.

## Perubahan dari Jobsheet 9

- Tambah `sql/02_users.sql` — tabel `users` (nama, username, password, role).
- Tambah `auth/register.php` + `auth/proses_register.php` (password disimpan dengan `password_hash()`, cek username duplikat), `auth/login.php` + `auth/proses_login.php` (`password_verify()`), `auth/logout.php` (`session_destroy()`).
- Tambah `includes/auth.php` — guard clause: redirect ke `auth/login.php` bila `$_SESSION['user_id']` belum ada. **Wajib di-include sebagai baris pertama** (sebelum `header.php`) agar `header('Location: ...')` masih bisa dipanggil sebelum ada output HTML.
- `includes/header.php`: `session_start()` dibuat `if (session_status() === PHP_SESSION_NONE)` agar tidak konflik dengan `auth.php` yang juga memulai session; navbar kini menampilkan nama petugas + Logout jika sudah login, atau link Login jika belum.
- Halaman yang **dikunci** (butuh login): `esport/tambah.php`, `esport/edit.php`, `esport/proses_tambah.php`, `esport/proses_edit.php`, `esport/hapus.php`, seluruh halaman `anggota/*`.
- Halaman yang **tetap publik**: `index.php` (Beranda) dan `esport/list.php` (daftar divisi bisa dilihat Tamu tanpa login). Kolom Aksi (Edit/Hapus) di `esport/list.php` hanya tampil kalau sudah login.

## Struktur Folder

```text
jobsheet-10/
├── includes/
│   ├── auth.php          (baru)
│   ├── header.php        (diubah)
│   ├── footer.php
│   └── koneksi.php
├── auth/                 (baru)
│   ├── register.php
│   ├── proses_register.php
│   ├── login.php
│   ├── proses_login.php
│   └── logout.php
├── esport/               (tambah, edit, proses_tambah, proses_edit, hapus: dikunci; list: publik)
├── anggota/              (seluruhnya dikunci)
├── assets/
├── sql/
│   ├── 01_divisi_anggota.sql
│   └── 02_users.sql      (baru)
├── index.php
└── README.md
```

## Persiapan database

Jalankan skema tambahan:

```
psql -p 5433 -U postgres -d esport_championship -f sql/02_users.sql
```

## Cara Menjalankan

**Opsi 1 — PHP built-in server:**

```
php -S localhost:8000
```

Uji: akses `http://localhost:8000/esport/tambah.php` langsung tanpa login → harus redirect ke halaman Login. Daftar akun via Register, login, coba akses halaman yang sama → berhasil.

**Opsi 2 — Laragon (Apache):** lewat virtual host langsung ke folder `jobsheet-10/` (mis. `http://jobsheet10.test/`), atau bersarang di bawah domain proyek (mis. `http://dp2026.test/kode-praktikum/jobsheet-10/`) — path CSS/JS/link/redirect login sudah relatif otomatis (lihat `includes/header.php` & `includes/auth.php`), jadi keduanya jalan.

## Catatan

- Guard `auth.php` mengembalikan HTTP 302 ke `auth/login.php` untuk halaman terkunci meski database belum tersambung (guard berjalan sebelum kode yang butuh koneksi DB).
- Perbedaan akses berdasarkan `role` (mis. hanya `admin` boleh hapus anggota) belum diterapkan di jobsheet ini — jadi tugas mandiri.
- Nilai `q` dari pencarian masih belum di-escape saat ditampilkan kembali (sisa Jobsheet 9) — diperbaiki menyeluruh di Jobsheet 11.
