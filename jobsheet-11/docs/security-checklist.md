# Security Checklist — E-Sport Championship (Jobsheet 11)

Audit keamanan web dasar untuk proyek E-Sport Championship. Setiap kerentanan dipetakan ke perbaikannya, lengkap dengan bukti **sebelum / sesudah**.

| No | Kerentanan | Status Jobsheet 10 | Perbaikan Jobsheet 11 | Status |
|----|-----------|--------------------|-----------------------|--------|
| 1 | XSS (Cross-Site Scripting) | Nilai pencarian `?q=` dicetak mentah ke `value=` | Semua output dibungkus `e()` | Aman |
| 2 | CSRF | Form POST tanpa token | Token tersembunyi + `csrf_verify()` | Aman |
| 3 | Session fixation | `session_regenerate_id(true)` sudah ada | Dipertahankan + token CSRF dirotasi setelah login | Aman |
| 4 | SQL Injection | Seluruh query sudah prepared statement | Diaudit ulang, tidak ada perubahan kode | Aman |

---

## 1. XSS

**Sebelum** (`esport/list.php`, `anggota/list.php`):

```php
<input type="search" name="q" value="<?= $q ?>">
```

Bukti serangan: buka `esport/list.php?q="><script>alert(1)</script>` → atribut `value` tertutup dan skrip dijalankan (pop-up muncul).

**Sesudah:**

```php
<input type="search" name="q" value="<?= e($q) ?>">
```

`e()` ada di `includes/helpers.php` (`htmlspecialchars` dengan `ENT_QUOTES | ENT_SUBSTITUTE`, UTF-8) dan di-`require_once` dari `includes/header.php`.

Hasil: `"><script>alert(1)</script>` tampil sebagai teks `&quot;&gt;&lt;script&gt;…` — tidak ada pop-up.

**Daftar output yang sudah dibungkus `e()`:**

| Data | File |
|------|------|
| Kode divisi, nama game, platform, roster | `esport/list.php`, `esport/edit.php` |
| No. anggota, nama player, role, no. HP | `anggota/list.php`, `anggota/edit.php` |
| Nilai pencarian `$q` | `esport/list.php`, `anggota/list.php` |
| Nama petugas di navbar, judul halaman | `includes/header.php` |
| Pesan flash (termasuk nama petugas saat login) | `includes/header.php` |
| Total divisi / anggota | `index.php` |
| Token CSRF di input hidden | `includes/csrf.php` |

Catatan: `id` dan `$p` (halaman) di-cast `(int)`, `q` di URL pagination memakai `urlencode()`.

Uji: tambah divisi dengan nama game `<script>alert(1)</script>` → di Daftar Divisi tampil sebagai teks, bukan pop-up.

---

## 2. CSRF

**Sebelum:** semua form POST (Tambah/Edit/Hapus Divisi & Anggota, Login, Register) bisa dikirim dari situs lain selama browser korban masih punya cookie session.

**Sesudah:**

- `includes/csrf.php`: `csrf_token()` (acak 32 byte, disimpan di session), `csrf_field()` (input hidden), `csrf_verify()` (`hash_equals`, balasan **HTTP 403** bila tidak cocok).
- `<?= csrf_field() ?>` ada di setiap `<form method="post">`:
  `auth/login.php`, `auth/register.php`, `esport/tambah.php`, `esport/edit.php`, `esport/list.php` (form Hapus), `anggota/tambah.php`, `anggota/edit.php`, `anggota/list.php` (form Hapus).
- `csrf_verify()` dipanggil di: `esport/proses_tambah.php`, `esport/proses_edit.php`, `esport/hapus.php`, `anggota/proses_tambah.php`, `anggota/proses_edit.php`, `anggota/hapus.php`, `auth/proses_login.php`, `auth/proses_register.php` — **sebelum** koneksi/query database.

**Urutan guard** (penting): `includes/auth.php` (cek login → redirect) dijalankan **lebih dulu**, baru `csrf_verify()`. Jadi request tanpa login tetap di-redirect ke Login, bukan 403.

Bukti uji:

```
curl -X POST http://localhost:8000/esport/proses_tambah.php -d "kode_divisi=x"   (tanpa login)  -> 302 ke auth/login.php
curl -X POST http://localhost:8000/auth/proses_login.php -d "username=a&password=b" (tanpa token) -> 403
curl -X POST http://localhost:8000/esport/proses_tambah.php -d "kode_divisi=x" -b <cookie login>  (tanpa csrf_token) -> 403
```

---

## 3. Session fixation

- `auth/proses_login.php` memanggil `session_regenerate_id(true)` **setelah** login berhasil (sudah ada sejak Jobsheet 10), sehingga ID session sebelum login tidak bisa dipakai penyerang.
- Tambahan Jobsheet 11: `unset($_SESSION['csrf_token'])` setelah regenerate, jadi token baru dibuat untuk sesi yang sudah login.
- Cookie session: `httponly = true` (tidak terbaca JavaScript), `samesite = Lax`, `secure` aktif lewat `SESSION_COOKIE_SECURE=1` saat HTTPS (Vercel).
- `auth/logout.php` mengosongkan `$_SESSION`, menghapus cookie, dan `session_destroy()`.

---

## 4. SQL Injection (audit ulang)

Tidak ada perubahan kode sejak Jobsheet 8 — seluruh query memakai **prepared statement** (`prepare()` + parameter terikat). Hasil audit:

| File | Query | Parameter |
|------|-------|-----------|
| `auth/proses_login.php` | `SELECT ... FROM users WHERE LOWER(username) = LOWER(:username)` | `:username` |
| `auth/proses_register.php` | cek duplikat + `INSERT INTO users` | `:username`, `:nama`, `:password` (hash) |
| `esport/list.php`, `anggota/list.php` | `ILIKE :kw`, `LIMIT :limit OFFSET :offset` | `:kw`, `:limit`, `:offset` (INT) |
| `esport/edit.php`, `anggota/edit.php` | `SELECT * ... WHERE id = :id` | `:id` (cast `(int)`) |
| `esport/proses_*.php`, `anggota/proses_*.php` | cek duplikat, `INSERT`, `UPDATE` | semua nilai lewat parameter |
| `esport/hapus.php`, `anggota/hapus.php` | `DELETE ... WHERE id = :id` | `:id` (cast `(int)`) |
| `includes/session.php` | handler session DB | `:id`, `:data`, `:detik` |
| `index.php` | `COUNT(*)` tanpa input pengguna | — |

Satu-satunya string yang disisipkan langsung ke SQL adalah `$where` di halaman list, dan isinya **konstanta di kode** (nama kolom tetap), bukan input pengguna. Input pengguna (`$q`) hanya masuk lewat `:kw`.

Uji: login dengan username `' OR '1'='1` → "Username atau password salah."; cari `'; DROP TABLE divisi;--` → diperlakukan sebagai teks pencarian biasa.

---

## Catatan keterbatasan (di luar cakupan jobsheet)

- `logout.php` masih lewat GET (logout paksa lewat link dari situs lain dampaknya kecil, tetapi bisa dijadikan POST + token sebagai pengembangan).
- Belum ada pembatasan percobaan login (rate limiting) dan pembedaan hak akses berdasarkan `role`.
