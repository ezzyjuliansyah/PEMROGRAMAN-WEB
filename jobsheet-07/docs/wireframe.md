# Jobsheet 4 — UI/UX Design

**Sub-CPMK:** Merancang UI/UX aplikasi (proyek).

Dokumen ini merancang wireframe dan user flow untuk fitur-fitur yang **belum dibangun** kodenya di project E-Sport Championship (Jobsheet 1-3): **Login**, **Dashboard**, serta penyempurnaan **Manajemen Divisi** dan **Manajemen Anggota** (fungsi Edit, Hapus, Search, dan Validasi yang belum ada di HTML statis saat ini).

> Catatan: seluruh wireframe di dokumen ini adalah rancangan antarmuka. Implementasinya (interaktivitas JS, lalu PHP/PostgreSQL) baru akan dikerjakan mulai Jobsheet 5 dan seterusnya.

## Perubahan dari Jobsheet 3

- Tidak ada perubahan kode — halaman HTML/CSS tetap sama persis dengan Jobsheet 3.
- Tambah `docs/wireframe.md`: wireframe teks + user flow untuk fitur yang belum dibangun (Login, Dashboard, Manajemen Divisi, Manajemen Anggota).

## Cara Menjalankan

Sama seperti Jobsheet 3 — buka `index.html`.

---

## Daftar Isi

1. [Struktur Menu & Fitur Utama](#1-struktur-menu--fitur-utama)
2. [User Flow](#2-user-flow)
3. [Wireframe Halaman (Low-Fidelity)](#3-wireframe-halaman-low-fidelity)
4. [Konsistensi Desain](#4-konsistensi-desain)
5. [Validasi & Edge Case](#5-validasi--edge-case)

---

## 1. Struktur Menu & Fitur Utama

| Fitur | Deskripsi |
|---|---|
| **A. Login** | Halaman autentikasi untuk admin/panitia sebelum mengakses fitur pengelolaan data. |
| **B. Dashboard** | Halaman ringkasan setelah login — menampilkan statistik divisi & anggota, dan akses cepat ke menu kelola. |
| **C. Manajemen Divisi** | Menampilkan seluruh divisi game aktif, detail divisi, formulir penambahan divisi baru, serta fungsi edit/hapus. |
| **D. Manajemen Anggota / Player** | Menampilkan roster anggota tim tiap divisi, pencarian data player, formulir pendaftaran anggota baru, serta fungsi edit/hapus. |

## 2. User Flow

### A. User Flow — Login

1. Buka halaman `login.html`
2. Input Username
3. Input Password
4. Klik tombol **Login**
5. Sistem validasi kredensial
6. Jika valid → masuk ke **Dashboard**; jika tidak valid → tampilkan pesan error di halaman Login

### B. User Flow — Dashboard

1. Berhasil login, diarahkan ke Dashboard
2. Tampil ringkasan statistik (Total Divisi, Total Anggota)
3. Pilih menu di navbar: Daftar Divisi / Tambah Divisi / Daftar Anggota / Tambah Anggota
4. Diarahkan ke halaman sesuai menu yang dipilih

### C. User Flow — Tambah Anggota / Player

1. Masuk Menu 'Tambah Anggota'
2. Pilih Divisi Game
3. Input Nama & Nickname
4. Tentukan Role/Peran
5. Klik 'Simpan Anggota'
6. Data Masuk ke 'Daftar Anggota'
7. Ringkasan Statistik Bertambah

### D. User Flow — Tambah & Kelola Divisi

1. Masuk Menu 'Tambah Divisi'
2. Input Nama Divisi & Kategori Game
3. Klik 'Simpan Divisi'
4. Tampil di 'Daftar Divisi'
5. Total Divisi di Beranda Terupdate

### E. User Flow — Edit & Hapus Data (Divisi / Anggota)

1. Buka Daftar Divisi atau Daftar Anggota
2. Klik tombol **Edit** pada baris data → form terisi otomatis dengan data yang dipilih → ubah data → Simpan → data di tabel terupdate
3. Klik tombol **Hapus** pada baris data → sistem tampilkan dialog konfirmasi → jika dikonfirmasi, data terhapus dari tabel dan statistik di Beranda ikut terupdate

### F. User Flow — Pencarian Data (Search)

1. Buka Daftar Anggota
2. Ketik kata kunci di kolom pencarian (nickname/divisi)
3. Tabel otomatis terfilter menampilkan hasil yang sesuai

---

## 3. Wireframe Halaman (Low-Fidelity)

### 3.1 Login

```
+-----------------------------------------------+
|              E-Sport Championship              |
|-------------------------------------------------|
|                                                 |
|                 [ LOGIN ]                       |
|                                                 |
|   Username : [_____________________]           |
|   Password : [_____________________]           |
|                                                 |
|                [   Login   ]                    |
|                                                 |
+-----------------------------------------------+
```

### 3.2 Dashboard / Beranda

```
+-------------------------------------------------------------+
| E-Sport Championship                                        |
| Beranda | Daftar Divisi | Tambah Divisi | Daftar Anggota... |
|---------------------------------------------------------------|
| Ringkasan Statistik                                          |
|  +-------------------+   +-------------------+               |
|  | TOTAL DIVISI GAME |   | TOTAL ANGGOTA      |               |
|  | 4 Divisi          |   | 20 Player          |               |
|  +-------------------+   +-------------------+               |
|                                                               |
|                © 2026 E-Sport Championship                   |
+-------------------------------------------------------------+
```

### 3.3 Daftar Divisi

```
+-------------------------------------------------------------+
| Daftar Divisi                                                |
|---------------------------------------------------------------|
| No | Nama Divisi     | Game            | Jml Player | Aksi   |
|----|------------------|-----------------|------------|--------|
| 1  | Mobile Legends   | Mobile Legends  | 6          | [E][H] |
| 2  | Valorant         | Valorant        | 5          | [E][H] |
| 3  | PUBG Mobile      | PUBG Mobile     | 5          | [E][H] |
| 4  | Free Fire        | Free Fire       | 4          | [E][H] |
+-------------------------------------------------------------+
[E] = Edit   [H] = Hapus
```

### 3.4 Form Tambah Anggota

```
+-----------------------------------------+
| Tambah Anggota                          |
|-------------------------------------------|
| Divisi        : [ Dropdown        v ]    |
| Nama Lengkap  : [_____________________]  |
| Nickname Game : [_____________________]  |
| Role/Peran    : [ Dropdown v ]           |
|                                           |
|              [   Simpan   ]              |
+-----------------------------------------+
```

### 3.5 Daftar Anggota

```
+-------------------------------------------------------------+
| Daftar Anggota                        [ Cari...      ] [Go] |
|---------------------------------------------------------------|
| No | Nickname | Divisi          | Role     | Kontak | Aksi   |
|----|----------|-----------------|----------|--------|--------|
| 1  | Acesky   | Mobile Legends  | Jungler  | 0812.. | [E][H] |
| 2  | Phantom  | Valorant        | Duelist  | 0813.. | [E][H] |
| 3  | Viper    | PUBG Mobile     | Rusher   | 0814.. | [E][H] |
+-------------------------------------------------------------+
```

---

## 4. Konsistensi Desain

- Warna navbar navy blue (`#1e293b` / `#0f172a`) dengan teks cyan/biru muda (`#38bdf8`), sesuai CSS Jobsheet 1-3.
- Komponen stat card dengan border-left aksen biru terang (`#0284c7`).
- Tata letak responsif dan tabel data yang seragam di seluruh halaman, mengikuti pola `table-responsive` dari Jobsheet 3.
- Tombol aksi (Simpan, Login, Edit, Hapus) memakai warna dan bentuk yang sama dengan tombol yang sudah ada di form Tambah Divisi/Anggota.

## 5. Validasi & Edge Case

- Username/Password tidak boleh kosong saat Login; kredensial salah menampilkan pesan error, bukan langsung masuk Dashboard.
- Nickname player tidak boleh kosong dan harus unik.
- Pemilihan divisi bersifat wajib (dropdown required) saat menambah anggota.
- Divisi yang masih memiliki anggota aktif tidak dapat langsung dihapus tanpa konfirmasi.
- Format input tervalidasi sebelum data disimpan ke sistem.
- Aksi Hapus (baik Divisi maupun Anggota) selalu melalui dialog konfirmasi untuk mencegah penghapusan tidak sengaja.
