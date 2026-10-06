# Jobsheet 12 — Integrasi Modul Peminjaman

**Proyek:** E-Sport Championship
**Sub-CPMK:** Mengintegrasikan front-end dan back-end proyek secara utuh.

## Konsep di project E-Sport

Jobsheet menggunakan contoh buku dan anggota. Di project ini dipetakan menjadi:

| Jobsheet | Project E-Sport |
|----------|-----------------|
| `anggota` | `anggota` (player) |
| `buku` | `divisi` (divisi game) |
| `buku.stok` | `divisi.roster` (jumlah slot roster yang masih tersedia) |
| Peminjaman buku | **Peminjaman player** ke sebuah divisi (seperti loan player di e-sport) |

## Perubahan dari Jobsheet 11

- Tambah `sql/03_peminjaman.sql` — tabel `peminjaman` (relasi ke `divisi` dan `anggota`, kolom `status` `dipinjam`/`selesai`, `tgl_pinjam`, `tgl_kembali`). Batas `divisi.roster` diturunkan dari `>= 1` menjadi `>= 0` supaya slot terakhir bisa terpakai.
- Tambah modul **Peminjaman**:
  - `peminjaman/tambah.php` + `proses_tambah.php` — pilih player + divisi (dropdown divisi hanya yang `roster > 0`), simpan transaksi **dan** kurangi roster dalam satu transaction (`beginTransaction` / `commit` / `rollBack`) dengan `SELECT ... FOR UPDATE` untuk mencegah race condition.
  - `peminjaman/kembali.php` + `proses_kembali.php` — daftar transaksi aktif (`status = 'dipinjam'`), tombol Kembalikan menambah kembali roster dalam transaction serupa.
  - `peminjaman/riwayat.php` — histori peminjaman per player (JOIN `peminjaman` + `divisi`).
- `includes/header.php`: navbar menambah menu Peminjaman Baru, Pengembalian, Riwayat (hanya saat login).
- `index.php`: kartu "Sedang Dipinjam" kini `COUNT(*) FROM peminjaman WHERE status = 'dipinjam'`.
- `esport/hapus.php` & `anggota/hapus.php`: divisi/anggota yang masih punya riwayat peminjaman ditolak dengan pesan yang jelas (bukan error 500).
- Semua form baru tetap memakai token CSRF dan output di-escape `e()` (Jobsheet 11).

## Cara menjalankan

Jalankan skema tambahan di database yang sama (`esport_championship`):

```
psql -p 5433 -U postgres -d esport_championship -f sql/03_peminjaman.sql
```

**Opsi 1 — PHP built-in server** (jalankan dari dalam folder `jobsheet-12/`):

```
php -S localhost:8000
```

**Opsi 2 — Laragon (Apache):** lewat virtual host langsung ke folder `jobsheet-12/` (mis. `http://jobsheet12.test/`), atau bersarang di bawah domain proyek — path CSS/JS/link/redirect login sudah relatif otomatis (lihat `includes/header.php` & `includes/auth.php`).

## Pengujian end-to-end yang disarankan

Registrasi petugas → Login → Tambah Divisi & Anggota → Peminjaman Baru → cek `roster` divisi berkurang di Daftar Divisi → cek kartu "Sedang Dipinjam" di Beranda bertambah → Pengembalian → cek roster kembali bertambah dan transaksi hilang dari daftar aktif → Riwayat (pilih player) → transaksi muncul berstatus "Selesai" → Logout.

## Catatan

- Validasi bisnis tambahan (player dengan peminjaman terlambat tidak boleh meminjam lagi) belum diterapkan — jadi tugas mandiri.
- Operasi roster memakai `SELECT ... FOR UPDATE` di dalam transaction, bukan sekadar `UPDATE divisi SET roster = roster - 1` tanpa pengecekan, agar roster tidak bisa negatif bila dua peminjaman diproses hampir bersamaan.
- Mengubah `roster` lewat Edit Divisi saat ada peminjaman aktif akan menggeser hitungan slot (roster dianggap "slot tersisa"). Sebaiknya ubah roster hanya jika tidak ada peminjaman aktif.
