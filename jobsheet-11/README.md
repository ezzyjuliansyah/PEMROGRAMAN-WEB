# Jobsheet 11 — Keamanan Web Dasar

**Proyek:** E-Sport Championship
**Sub-CPMK:** Menerapkan prinsip keamanan web dasar.

## Perubahan dari Jobsheet 10

- Tambah `includes/helpers.php` (`e()` untuk `htmlspecialchars`) dan `includes/csrf.php` (`csrf_token()`, `csrf_field()`, `csrf_verify()`), keduanya di-`require_once` dari `includes/header.php`.
- **XSS:** seluruh output data dari database/`$_GET` (kode divisi, nama game, platform, nama, role, no. anggota, no. HP, nilai pencarian, nama petugas di navbar) dibungkus `e()`.
- **CSRF:** token tersembunyi ditambahkan ke semua form POST (Tambah/Edit/Hapus Divisi & Anggota, Login, Register); setiap `proses_*.php` dan `hapus.php` memanggil `csrf_verify()` sebelum menyentuh database.
- **Session fixation:** `session_regenerate_id(true)` dipanggil di `auth/proses_login.php` setelah login berhasil (token CSRF ikut dirotasi).
- **SQL Injection:** diaudit ulang (tidak ada perubahan kode — sejak Jobsheet 8 semua query sudah prepared statement).
- Tambah `docs/security-checklist.md` — dokumen audit lengkap dengan bukti before/after per kerentanan.

## Cara menjalankan

**Opsi 1 — PHP built-in server:**

```
php -S localhost:8000
```

**Opsi 2 — Laragon (Apache):** lewat virtual host langsung ke folder `jobsheet-11/` (mis. `http://jobsheet11.test/`), atau bersarang di bawah domain proyek (mis. `http://dp2026.test/kode-praktikum/jobsheet-11/`) — path CSS/JS/link/redirect login sudah relatif otomatis (lihat `includes/header.php` & `includes/auth.php`), jadi keduanya jalan.

Database sama seperti Jobsheet 10 (`sql/01_divisi_anggota.sql` dan `sql/02_users.sql`), tidak ada skema baru.

## Cara menguji

- **CSRF:** login, lalu coba kirim `curl -X POST http://localhost:8000/esport/proses_tambah.php -d "kode_divisi=x"` tanpa `csrf_token` (sertakan cookie session) → harus mendapat HTTP 403.
- **XSS:** tambah divisi dengan nama game `<script>alert(1)</script>` → di Daftar Divisi harus tampil sebagai teks, bukan pop-up. Cari `"><script>alert(1)</script>` di kolom pencarian → tampil sebagai teks di kotak cari.
- **Guard order:** akses `esport/proses_tambah.php` lewat POST tanpa login sama sekali → tetap redirect ke Login (guard `auth.php` jalan lebih dulu daripada `csrf_verify()`), sudah diverifikasi otomatis.

## Catatan

- Lihat `docs/security-checklist.md` untuk rincian audit dan pemetaan tiap kerentanan ke perbaikannya.
