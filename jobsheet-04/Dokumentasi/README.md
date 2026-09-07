# Dokumentasi Jobsheet 4 — UI/UX Design

Dokumentasi ini melanjutkan dokumentasi jobsheet-03 dan ditujukan untuk mahasiswa yang baru belajar merancang UI/UX. Kalau kamu belum paham konsep responsive design (jobsheet-03) — media query, checkbox hack, tabel scroll — sebaiknya baca dulu dokumentasi jobsheet sebelumnya.

**Sub-CPMK:** Merancang UI/UX aplikasi (proyek).

## Apa yang Baru di Jobsheet 4?

Berbeda dari jobsheet-jobsheet sebelumnya, di jobsheet ini **tidak ada perubahan kode sama sekali**. Fokusnya murni di tahap **perancangan (design)**, sebelum fitur baru mulai diimplementasikan dari Jobsheet 5 dan seterusnya.

Yang ditambahkan:

1. `docs/wireframe.md` — dokumen wireframe teks + user flow untuk fitur yang belum dibangun: **Login**, **Dashboard**, dan penyempurnaan **Manajemen Divisi** & **Manajemen Anggota** (Edit, Hapus, Search, Validasi).
2. `infografis.png` — ringkasan visual dari proses perancangan UI/UX ini dalam bentuk satu poster infografis.

## Daftar Isi

1. [Apa itu UI/UX Design?](#1-apa-itu-uiux-design)
2. [Kenapa Merancang Dulu Sebelum Coding?](#2-kenapa-merancang-dulu-sebelum-coding)
3. [Apa itu Wireframe?](#3-apa-itu-wireframe)
4. [Apa itu User Flow?](#4-apa-itu-user-flow)
5. [Cara Membaca `docs/wireframe.md`](#5-cara-membaca-docswireframemd)
6. [Rangkuman & Latihan Lanjutan](#6-rangkuman--latihan-lanjutan)

---

## 1. Apa itu UI/UX Design?

**UI (User Interface)** adalah tampilan visual yang dilihat dan disentuh pengguna — tombol, warna, tata letak, tipografi. **UX (User Experience)** adalah keseluruhan pengalaman pengguna saat memakai aplikasi — apakah alurnya mudah dipahami, apakah tugasnya bisa diselesaikan tanpa bingung.

Analogi sederhana: UI itu "bentuk dan tampilan rumah" (cat, furnitur, dekorasi), sedangkan UX itu "seberapa nyaman dan gampang kamu bergerak di dalam rumah itu" (posisi pintu, alur ruangan).

## 2. Kenapa Merancang Dulu Sebelum Coding?

Di jobsheet-jobsheet sebelumnya, kita langsung menulis HTML/CSS. Tapi untuk fitur baru yang lebih kompleks (Login, Dashboard, Edit/Hapus data), langsung coding tanpa rancangan berisiko:

- Alur pengguna jadi membingungkan (tombol di tempat yang salah, langkah yang berputar-putar).
- Banyak revisi kode karena struktur halaman ternyata kurang pas.
- Sulit didiskusikan dengan tim/dosen karena belum ada gambaran visual, cuma ada di kepala.

Makanya sebelum coding, dibuat dulu **wireframe** (sketsa tampilan) dan **user flow** (alur langkah pengguna) dalam bentuk dokumen — supaya rancangannya bisa dicek dan didiskusikan dulu sebelum satu baris kode pun ditulis.

## 3. Apa itu Wireframe?

Wireframe adalah sketsa/kerangka tampilan halaman, biasanya masih hitam-putih dan sangat sederhana (disebut **low-fidelity**), fokus ke **tata letak** (layout) — di mana posisi navbar, form, tabel, tombol — bukan ke detail visual seperti warna atau font.

Di `docs/wireframe.md`, wireframe digambarkan dengan kotak-kotak teks (ASCII art) seperti ini:

```
+-----------------------------------------------+
|              E-Sport Championship              |
|-------------------------------------------------|
|   Username : [_____________________]           |
|   Password : [_____________________]           |
|                [   Login   ]                    |
+-----------------------------------------------+
```

Level "kesetiaan" (fidelity) wireframe ada beberapa tingkat:
- **Low-fidelity** — kotak dan teks sederhana (yang dipakai di jobsheet ini)
- **Mid-fidelity** — sudah ada warna dasar dan komponen mendekati asli
- **High-fidelity** — sudah seperti desain final (biasanya dibuat di Figma/Canva)

## 4. Apa itu User Flow?

User flow adalah **urutan langkah** yang dilakukan pengguna untuk menyelesaikan satu tugas, dari awal sampai selesai. Contoh dari `docs/wireframe.md`:

```
Masuk Menu 'Tambah Anggota' → Pilih Divisi Game → Input Nama & Nickname
→ Tentukan Role/Peran → Klik 'Simpan Anggota' → Data Masuk ke 'Daftar Anggota'
→ Ringkasan Statistik Bertambah
```

Tujuannya untuk memastikan setiap fitur punya alur yang jelas dan logis **sebelum** dibangun jadi kode — kalau alurnya sudah membingungkan di atas kertas, pasti akan lebih membingungkan lagi kalau langsung jadi kode.

## 5. Cara Membaca `docs/wireframe.md`

Dokumen `docs/wireframe.md` dibagi jadi 5 bagian:

1. **Struktur Menu & Fitur Utama** — daftar fitur apa saja yang dirancang (Login, Dashboard, Manajemen Divisi, Manajemen Anggota).
2. **User Flow** — alur langkah per fitur (Login, Dashboard, Tambah Anggota, Tambah Divisi, Edit/Hapus, Search).
3. **Wireframe Halaman** — sketsa tata letak tiap halaman dalam bentuk kotak teks.
4. **Konsistensi Desain** — aturan warna, komponen, dan tata letak supaya semua halaman terasa "satu keluarga".
5. **Validasi & Edge Case** — aturan-aturan yang harus dipatuhi sistem nanti (misalnya field wajib diisi, konfirmasi sebelum hapus data).

## 6. Rangkuman & Latihan Lanjutan

Ringkasan konsep yang dipelajari di jobsheet ini:

- UI adalah tampilan, UX adalah pengalaman — keduanya harus dirancang bersamaan.
- Merancang dulu (wireframe + user flow) sebelum coding menghemat waktu revisi di kemudian hari.
- Wireframe low-fidelity fokus ke tata letak, bukan detail visual.
- User flow memetakan langkah pengguna dari awal sampai tujuan tercapai.

Latihan lanjutan yang bisa dicoba sendiri:

- Coba gambar ulang salah satu wireframe di `docs/wireframe.md` (misalnya halaman Login) memakai tools seperti Figma atau Canva, jadi versi high-fidelity berwarna.
- Coba buat user flow untuk fitur yang belum ada di dokumen ini, misalnya "Logout" atau "Lupa Password".
- Bandingkan wireframe kamu dengan tampilan HTML asli di Jobsheet 1-3, cek apakah tata letaknya konsisten.
