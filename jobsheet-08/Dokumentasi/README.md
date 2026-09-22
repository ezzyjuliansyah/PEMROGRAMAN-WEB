# Dokumentasi Jobsheet 8 — Koneksi PostgreSQL & PDO

**Proyek:** E-Sport Championship  
**Nama:** Ezzy Juliansyah Dwihersan  
**NIM:** 254107060019  
**Absen:** 9  
**Program Studi:** D-IV Sistem Informasi Bisnis  
**Jurusan:** Teknologi Informasi  
**Institusi:** Politeknik Negeri Malang

Dokumentasi ini menjelaskan pengembangan project E-Sport Championship dari Jobsheet 7 menuju Jobsheet 8. Tema, halaman, dan desain utama tetap dipertahankan, sedangkan penyimpanan data dipindahkan dari session ke PostgreSQL menggunakan PDO.

## Daftar Dokumentasi

1. Konsep dasar database dan SQL
2. Skema database E-Sport Championship
3. Persiapan database PostgreSQL
4. Koneksi PDO
5. INSERT dengan prepared statement
6. Membaca data dengan SELECT
7. Rangkuman latihan dan pengujian
8. Instalasi/konfigurasi PostgreSQL pada Laragon

## Inti Perubahan

| Jobsheet 7 | Jobsheet 8 |
|---|---|
| `$_SESSION['divisi']` | tabel `divisi` PostgreSQL |
| `$_SESSION['anggota']` | tabel `anggota` PostgreSQL |
| `foreach ($_SESSION...)` | `SELECT * ... ORDER BY id DESC` |
| `count($_SESSION...)` | `SELECT COUNT(*)` |
| Penyimpanan sementara | Penyimpanan persisten |
| Belum ada PDO | PDO driver `pgsql` |

Session masih digunakan untuk `flash message`, tetapi bukan sebagai penyimpanan data utama.
