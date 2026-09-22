# 1. Konsep Dasar Database dan SQL

Pada Jobsheet 8, data project E-Sport Championship dipindahkan dari penyimpanan session ke database relasional PostgreSQL.

## Database

Database adalah kumpulan data yang tersusun dan dapat dikelola menggunakan sistem manajemen basis data. Pada project ini digunakan PostgreSQL.

## Tabel

Project menggunakan dua tabel utama:

- `divisi` untuk menyimpan data divisi game.
- `anggota` untuk menyimpan data player.

## SQL

SQL digunakan untuk membuat struktur dan mengolah data. Perintah yang digunakan pada jobsheet ini antara lain:

- `CREATE TABLE` untuk membuat tabel.
- `INSERT` untuk menambah data.
- `SELECT` untuk membaca data.
- `COUNT(*)` untuk menghitung jumlah data.

Perubahan konsep dari Jobsheet 7 adalah data tidak lagi bergantung pada masa hidup session browser.
