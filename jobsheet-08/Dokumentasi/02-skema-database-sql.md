# 2. Skema Database E-Sport Championship

## Tabel `divisi`

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | SERIAL | Primary key |
| `kode` | VARCHAR(20) | Kode divisi, unik |
| `nama_game` | VARCHAR(100) | Nama game |
| `platform` | VARCHAR(50) | Platform game |
| `roster` | INTEGER | Jumlah roster, minimal 1 |

## Tabel `anggota`

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | SERIAL | Primary key |
| `no_anggota` | VARCHAR(20) | Nomor anggota, unik |
| `nama` | VARCHAR(100) | Nama player |
| `role` | VARCHAR(50) | Role/posisi player |
| `no_hp` | VARCHAR(20) | Nomor HP |

DDL lengkap terdapat pada `sql/01_divisi_anggota.sql`.
