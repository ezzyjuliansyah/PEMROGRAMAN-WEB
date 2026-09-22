# Wireframe Jobsheet 8 — E-Sport Championship

## 1. Dashboard

```text
+-------------------------------------------------------------+
|                 E-SPORT CHAMPIONSHIP                         |
|-------------------------------------------------------------|
| Beranda | Daftar Divisi | Tambah Divisi | Daftar Anggota   |
|-------------------------------------------------------------|
| Dashboard                                                   |
| Selamat datang di Web Pengelola Data Divisi & Anggota...    |
|                                                             |
| +-------------------+   +-------------------+               |
| | TOTAL DIVISI      |   | TOTAL ANGGOTA     |               |
| | 5 Divisi          |   | 3 Player          |               |
| +-------------------+   +-------------------+               |
+-------------------------------------------------------------+
```

## 2. Form Tambah Divisi

```text
+-----------------------------------------+
| Form Tambah Divisi                      |
|-----------------------------------------|
| Kode Divisi   : [____________________]  |
| Nama Game     : [____________________]  |
| Platform      : [____________________]  |
| Jumlah Roster : [____________________]  |
|                                         |
|             [ Simpan ] [ Reset ]        |
+-----------------------------------------+
```

## 3. Daftar Divisi

```text
+-------------------------------------------------------------+
| Daftar Divisi Game                                          |
|-------------------------------------------------------------|
| Kode | Nama Game       | Platform | Roster | Aksi           |
| D001 | Mobile Legends  | Mobile   | 6      | Edit | Hapus    |
| D002 | Valorant        | PC       | 5      | Edit | Hapus    |
+-------------------------------------------------------------+
```

## 4. Form Tambah Anggota

```text
+-----------------------------------------+
| Form Tambah Anggota Player              |
|-----------------------------------------|
| No. Anggota : [____________________]    |
| Nama Player : [____________________]    |
| Role/Posisi : [____________________]    |
| No. HP      : [____________________]    |
|                                         |
|             [ Simpan ] [ Reset ]        |
+-----------------------------------------+
```

## 5. Daftar Anggota

```text
+-------------------------------------------------------------+
| Daftar Anggota Player                                       |
|-------------------------------------------------------------|
| No | Nama Player | Role | No. HP | Aksi                    |
| P001 | Acesky     | Jungler | 0812.. | Edit | Hapus       |
+-------------------------------------------------------------+
```

## Perubahan Jobsheet 8

Tampilan tetap menggunakan desain Jobsheet 7. Perubahan utama berada pada sumber data:

```text
Jobsheet 7:
Form -> POST -> Session -> list.php

Jobsheet 8:
Form -> POST -> PDO Prepared Statement -> PostgreSQL -> SELECT -> list.php
```
