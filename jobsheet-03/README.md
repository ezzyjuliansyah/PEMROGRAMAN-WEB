# Dokumentasi Jobsheet 3 — Responsive Design

Dokumentasi ini melanjutkan dokumentasi jobsheet-02 dan ditujukan untuk mahasiswa yang baru belajar HTML/CSS. Kalau kamu belum paham HTML dasar (jobsheet-01) atau CSS dasar — Flexbox, Grid, box model (jobsheet-02) — sebaiknya baca dulu dokumentasi jobsheet sebelumnya karena bab-bab di sini akan sering merujuk balik ke sana.

## Apa yang Baru di Jobsheet 3?

Ada 4 penambahan dari jobsheet-02:

1. Tag `<meta name="viewport">` di semua halaman.
2. Menu **hamburger** (ikon ☰) di layar sempit, dibuat murni dengan CSS memakai teknik **checkbox hack** (tanpa JavaScript sama sekali).
3. Tabel dibungkus `<div class="table-responsive">` supaya bisa di-scroll ke samping di layar sempit, alih-alih memampatkan kolom sampai tidak terbaca.
4. **Media query** di `style.css` yang mengubah grid kartu statistik dari 3 kolom → 2 kolom → 1 kolom mengikuti lebar layar.

Semua perubahan ini masuk dalam topik besar **Responsive Web Design** — membuat satu halaman web yang tampilannya menyesuaikan diri secara otomatis di berbagai ukuran layar (HP, tablet, laptop, monitor besar), tanpa perlu membuat halaman terpisah untuk tiap perangkat.

## Daftar Isi

1. [Konsep Dasar Responsive Design](#1-konsep-dasar-responsive-design)
2. [Apa yang Berubah di File HTML?](#2-apa-yang-berubah-di-file-html)
3. [CSS: Menu Hamburger dengan Checkbox Hack](#3-css-menu-hamburger-dengan-checkbox-hack)
4. [CSS: Tabel yang Bisa Di-scroll (`table-responsive`)](#4-css-tabel-yang-bisa-di-scroll-table-responsive)
5. [CSS: Media Query & Breakpoint](#5-css-media-query--breakpoint)
6. [Rangkuman & Latihan Lanjutan](#6-rangkuman--latihan-lanjutan)

## Struktur Folder

```
jobsheet-03/
├─ index.html
├─ assets/
│   └─ css/
│       └─ style.css      # Ditambah checkbox hack + media query
├─ esport/
│   ├─ list.html           # Tabel dibungkus .table-responsive
│   └─ tambah.html
├─ anggota/
│   ├─ list.html           # Tabel dibungkus .table-responsive
│   └─ tambah.html
└─ README.md
```

---

## 1. Konsep Dasar Responsive Design

Responsive design artinya tampilan web menyesuaikan diri otomatis mengikuti lebar layar perangkat, tanpa perlu bikin halaman terpisah untuk mobile dan desktop. Tiga kunci utama yang dipakai di jobsheet ini:

- **Viewport meta tag** — memberi tahu browser mobile untuk menampilkan halaman sesuai lebar layar asli perangkat, bukan di-zoom out seperti tampilan desktop.
- **Flexible layout (Grid/Flexbox)** — elemen bisa berubah susunan (misalnya jumlah kolom) mengikuti ruang yang tersedia.
- **Media query** — aturan CSS yang hanya berlaku pada kondisi tertentu, misalnya "kalau lebar layar ≤480px, terapkan style ini".

Tiga breakpoint yang dipakai di jobsheet ini:

| Breakpoint | Lebar layar | Contoh perangkat |
|---|---|---|
| Desktop | ≥1024px | Laptop, monitor |
| Tablet | ~768px | iPad, tablet |
| Mobile | ≤480px | HP |

## 2. Apa yang Berubah di File HTML?

Perubahan di HTML cuma menambahkan 2 elemen baru di dalam `<header>`, sebelum `<nav>` — sebuah checkbox tersembunyi dan sebuah label yang jadi ikon hamburger:

```html
<header>
    <h1>E-Sport Championship</h1>
    <input type="checkbox" id="nav-toggle" class="nav-toggle">
    <label for="nav-toggle" class="nav-toggle-label">&#9776;</label>
    <nav>
        <ul>...</ul>
    </nav>
</header>
```

Selain itu, di `esport/list.html` dan `anggota/list.html`, elemen `<table>` sekarang dibungkus satu `<div>` tambahan:

```html
<div class="table-responsive">
    <table border="1">
        ...
    </table>
</div>
```

Tidak ada perubahan lain di struktur HTML — form dan konten di halaman `tambah.html` tetap sama seperti jobsheet-02.

## 3. CSS: Menu Hamburger dengan Checkbox Hack

Checkbox hack adalah trik CSS lawas yang memanfaatkan status "checked" pada checkbox untuk mengubah tampilan elemen lain — tanpa satu baris JavaScript pun.

```css
.nav-toggle {
    display: none;
}

.nav-toggle-label {
    display: none;
}

@media (max-width: 480px) {
    .nav-toggle-label {
        display: block;
        cursor: pointer;
        font-size: 1.8rem;
        color: #fff;
        text-align: right;
    }

    nav ul {
        display: none;
        flex-direction: column;
    }

    .nav-toggle:checked ~ nav ul {
        display: flex;
    }
}
```

Cara kerjanya, langkah demi langkah:

1. Checkbox (`.nav-toggle`) disembunyikan dari tampilan (`display: none`), tapi tetap berfungsi secara logika.
2. Label (`.nav-toggle-label`) yang terhubung ke checkbox lewat atribut `for="nav-toggle"` dijadikan tombol berbentuk ikon ☰. Klik di mana saja pada label = mencentang/melepas centang checkbox.
3. Selector `.nav-toggle:checked ~ nav ul` membaca: "kalau checkbox berstatus checked, tampilkan `<ul>` di dalam elemen `<nav>` yang posisinya setelah checkbox itu (sibling)".
4. Semua ini hanya aktif di dalam `@media (max-width: 480px)` — di layar lebih lebar dari itu, menu tetap tampil mendatar seperti biasa dan ikon hamburgernya tersembunyi.

## 4. CSS: Tabel yang Bisa Di-scroll (`table-responsive`)

Masalah umum: tabel dengan banyak kolom akan dipaksa menyempit di layar kecil, sampai isinya terpotong atau tidak terbaca. Solusinya bukan menyempitkan tabel, tapi membiarkan tabel tetap selebar aslinya dan memberi area scroll di sekelilingnya.

```css
.table-responsive {
    width: 100%;
    overflow-x: auto;
}

.table-responsive table {
    min-width: 600px;
}

.table-responsive th,
.table-responsive td {
    white-space: nowrap;
}
```

Penjelasan tiap baris:

- `overflow-x: auto` pada pembungkus (`.table-responsive`) memunculkan scrollbar horizontal otomatis kalau isinya lebih lebar dari kontainer.
- `min-width: 600px` pada `table` mencegah tabel dipaksa menyusut mengikuti layar — ini kunci utamanya, tanpa baris ini tabel akan tetap menyempit dan `overflow-x` tidak akan pernah aktif.
- `white-space: nowrap` mencegah teks di dalam sel terpotong ke baris baru, supaya lebar kolom tetap konsisten.

## 5. CSS: Media Query & Breakpoint

Grid kartu statistik di halaman Beranda (`section#ringkasan`) diatur ulang jumlah kolomnya lewat media query:

```css
section#ringkasan {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}

@media (max-width: 768px) {
    section#ringkasan {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 480px) {
    section#ringkasan {
        grid-template-columns: 1fr;
    }
}
```

Cara membacanya: aturan CSS di luar media query berlaku sebagai default (desktop, 3 kolom). Begitu lebar layar browser turun ke 768px atau kurang, aturan di dalam `@media (max-width: 768px)` "menimpa" aturan default menjadi 2 kolom. Turun lagi ke 480px atau kurang, aturan `@media (max-width: 480px)` menimpanya lagi menjadi 1 kolom.

Urutan penulisan media query ini penting — ditulis dari breakpoint terbesar ke terkecil, supaya aturan yang lebih spesifik (mobile) selalu jadi yang terakhir "menang".

## 6. Rangkuman & Latihan Lanjutan

Ringkasan konsep yang dipelajari di jobsheet ini:

- Viewport meta tag membuat halaman menyesuaikan lebar layar asli perangkat.
- Checkbox hack memungkinkan interaksi show/hide tanpa JavaScript, memanfaatkan pseudo-class `:checked` dan combinator `~`.
- Overflow scroll (`overflow-x: auto`) + `min-width` adalah pola umum untuk menangani tabel/konten lebar di layar sempit.
- Media query mengubah aturan CSS berdasarkan kondisi lebar layar, ditulis dari breakpoint besar ke kecil.

Latihan lanjutan yang bisa dicoba sendiri untuk memperdalam pemahaman:

- Coba ubah breakpoint mobile dari 480px ke 600px, amati di lebar berapa hamburger menu mulai muncul.
- Coba hapus `min-width` pada `.table-responsive table` dan lihat apa yang terjadi pada tabel di layar sempit.
- Coba tambahkan animasi transisi (`transition`) saat menu hamburger dibuka/ditutup.
