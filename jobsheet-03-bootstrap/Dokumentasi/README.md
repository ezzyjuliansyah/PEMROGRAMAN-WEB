# Dokumentasi Jobsheet 3 (Versi Bootstrap) — Responsive Design dengan Framework

Dokumentasi ini menjelaskan perubahan dari Jobsheet 3 versi CSS murni ke versi Bootstrap 5, ditujukan untuk mahasiswa yang baru belajar memakai CSS framework.

**Sub-CPMK:** Membangun tampilan responsif memakai framework CSS (Bootstrap 5).

## Kenapa Pakai Framework?

Di Jobsheet 3 versi CSS murni, semua aturan responsif (checkbox hack, media query, table-responsive) ditulis manual dari nol. Framework seperti Bootstrap menyediakan komponen dan utility class siap pakai untuk pola-pola umum ini, sehingga:

- Lebih cepat membangun tampilan (tidak perlu menulis ulang CSS dasar).
- Konsisten — semua developer yang pakai Bootstrap mengikuti sistem grid dan komponen yang sama.
- Lebih sedikit bug lintas-browser, karena Bootstrap sudah teruji di banyak browser.

Trade-off-nya: ukuran file lebih besar (harus memuat Bootstrap dari CDN) dan kontrol detail desain sedikit lebih terbatas dibanding menulis CSS sendiri.

## Perubahan dari Jobsheet 3 (CSS Murni)

- Bootstrap 5.3 dimuat via CDN (`bootstrap.min.css` + `bootstrap.bundle.min.js`).
- Navbar: hamburger memakai komponen `.navbar` / `.navbar-toggler` / `.collapse` bawaan Bootstrap (butuh JavaScript bundle dari Bootstrap), menggantikan checkbox hack murni CSS.
- Kartu statistik: grid CSS manual diganti sistem grid 12 kolom Bootstrap (`.row` / `.col-md-6`).
- Section dibungkus komponen `.card` menggantikan styling `<section>` custom.
- Tabel & form memakai utility class Bootstrap (`.table-striped`, `.table-hover`, `.form-control`, `.btn-warning`, `.btn-danger`, dst).
- `assets/css/style.css` menyusut dari ~245 baris menjadi ~25 baris (hanya override warna brand).

## Tabel Perbandingan: Class Bootstrap vs CSS Murni

| Kebutuhan | CSS Murni (Jobsheet 3) | Bootstrap (Jobsheet 3 versi Bootstrap) |
|---|---|---|
| Navbar responsif | `input[type=checkbox]` + `label` (checkbox hack), `nav ul { display:flex }` | `.navbar`, `.navbar-expand-lg`, `.navbar-toggler`, `.collapse`, `.navbar-nav` |
| Toggle menu mobile | `.nav-toggle:checked ~ nav ul` (murni CSS, tanpa JS) | `data-bs-toggle="collapse"` + `data-bs-target` (butuh `bootstrap.bundle.min.js`) |
| Grid kolom statistik | `display:grid; grid-template-columns: repeat(3,1fr)` + media query manual | `.row` + `.col-md-6` (otomatis 1 kolom di layar kecil, tanpa media query manual) |
| Pembungkus konten | `<section>` dengan style manual (background, padding, shadow) | `.card`, `.card-body`, `.shadow-sm` |
| Tabel scroll horizontal | `.table-responsive` custom (`overflow-x:auto`, `min-width`) | `.table-responsive` bawaan Bootstrap (perilaku sama, tanpa nulis CSS) |
| Style baris tabel | `tr:nth-child(even)` manual | `.table-striped` |
| Efek hover baris | Tidak ada (perlu ditulis manual) | `.table-hover` |
| Style input form | `input { padding; border; border-radius }` manual | `.form-control` |
| Style tombol | `button { background-color; padding; border-radius }` manual | `.btn`, `.btn-primary`, `.btn-warning`, `.btn-danger`, `.btn-secondary` |
| Breakpoint responsif | Custom: mobile ≤480px, tablet ~768px | Bawaan Bootstrap: mobile <768px, tablet ~768–991px, desktop ≥992px |

## Cara Menjalankan

Buka `index.html` di browser (**butuh koneksi internet** karena Bootstrap dimuat dari CDN), uji dengan DevTools responsive mode pada breakpoint Bootstrap (mobile <768px, tablet ~768–991px, desktop ≥992px).

## Catatan

- Warna brand E-Sport Championship (`#1e293b`, `#38bdf8`, `#0284c7`) bukan bagian dari tema bawaan Bootstrap, sehingga tetap ditulis manual lewat `assets/css/style.css` yang sudah menyusut jauh lebih ringkas.
- Fungsionalitas dan konten halaman identik dengan Jobsheet 3 versi CSS murni — bedanya cuma cara membangun tampilannya.
