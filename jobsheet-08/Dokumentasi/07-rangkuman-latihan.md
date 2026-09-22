# 7. Rangkuman Latihan dan Pengujian

## Alur Tambah Data

```text
Form tambah
    ↓
POST
    ↓
proses_tambah.php
    ↓
Validasi server-side
    ↓
PDO prepared statement
    ↓
INSERT ... RETURNING id
    ↓
PostgreSQL
    ↓
Redirect ke list.php
```

## Pengujian

| No | Skenario | Hasil yang diharapkan |
|---|---|---|
| 1 | Membuka dashboard | Berhasil dan jumlah data berasal dari DB |
| 2 | Membuka daftar divisi | Data dibaca dengan SELECT |
| 3 | Menambah divisi valid | Data masuk PostgreSQL |
| 4 | Mengirim divisi kosong | Ditolak oleh validasi server |
| 5 | Membuka daftar anggota | Data dibaca dengan SELECT |
| 6 | Menambah anggota valid | Data masuk PostgreSQL |
| 7 | No. anggota duplikat | Ditolak |
| 8 | Menutup lalu membuka browser | Data tetap tersimpan |
