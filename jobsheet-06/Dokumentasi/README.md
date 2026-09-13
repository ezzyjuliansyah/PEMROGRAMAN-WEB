# Dokumentasi Jobsheet 6 — Fetch API & JSON

Dokumentasi ini melanjutkan dokumentasi jobsheet-05 dan ditujukan untuk mahasiswa yang baru belajar mengambil data dari luar halaman HTML. Kalau kamu belum paham DOM & Event dasar (jobsheet-05) — `addEventListener`, manipulasi elemen, validasi form — sebaiknya baca dulu dokumentasi jobsheet sebelumnya.

**Sub-CPMK:** Menerapkan komunikasi asinkron (AJAX/fetch, JSON).

## Apa yang Baru di Jobsheet 6?

Di Jobsheet 1-5, semua data (daftar divisi, daftar anggota) ditulis langsung di dalam HTML — kalau datanya berubah, harus edit HTML secara manual. Di jobsheet ini, data dipindahkan ke file terpisah (`data/divisi.json`, `data/anggota.json`) dan diambil secara **asinkron** memakai `fetch()`, lalu dirender ke tabel oleh JavaScript.

## Daftar Isi

1. [Apa itu JSON?](#1-apa-itu-json)
2. [Apa itu Fetch API?](#2-apa-itu-fetch-api)
3. [Apa itu Asinkron, `async`/`await`?](#3-apa-itu-asinkron-asyncawait)
4. [Loading Indicator](#4-loading-indicator)
5. [Penanganan Error dengan `try/catch`](#5-penanganan-error-dengan-trycatch)
6. [Kenapa Konfirmasi Hapus Diubah ke Event Delegation?](#6-kenapa-konfirmasi-hapus-diubah-ke-event-delegation)
7. [Kenapa Harus Pakai Server Lokal? (CORS)](#7-kenapa-harus-pakai-server-lokal-cors)
8. [Rangkuman & Latihan Lanjutan](#8-rangkuman--latihan-lanjutan)

---

## 1. Apa itu JSON?

JSON (**J**ava**S**cript **O**bject **N**otation) adalah format teks untuk menyimpan data terstruktur, mirip seperti objek JavaScript tapi dalam bentuk file `.json`. Contoh dari `data/divisi.json`:

```json
[
    {
        "kode": "D001",
        "nama_game": "Mobile Legends",
        "platform": "Mobile",
        "roster": 6
    }
]
```

Ini adalah **array** berisi beberapa **object**. Tiap object punya pasangan `"key": value` — persis seperti kolom di tabel (`kode`, `nama_game`, `platform`, `roster`).

## 2. Apa itu Fetch API?

`fetch()` adalah fungsi bawaan JavaScript untuk mengambil data dari sebuah alamat (URL atau file), tanpa perlu me-reload halaman. Contoh dari `assets/js/esport.js`:

```js
const response = await fetch('../data/divisi.json');
const daftarDivisi = await response.json();
```

Baris pertama meminta file `divisi.json`. Baris kedua mengubah isi response menjadi array/object JavaScript yang bisa diolah (misalnya di-looping dengan `forEach`).

## 3. Apa itu Asinkron, `async`/`await`?

Mengambil data (apalagi dari internet) butuh waktu — bisa 100ms, bisa 3 detik, tergantung koneksi. Kalau JavaScript menunggu proses itu secara "biasa", seluruh halaman akan macet (freeze) sampai datanya datang.

**Asinkron** artinya kode lain tetap bisa jalan sambil menunggu proses yang lama itu selesai di belakang layar. Kata kunci `async` dan `await` membuat kode asinkron ini gampang dibaca, seperti kode biasa yang berurutan:

```js
async function muatDataDivisi(tbody) {
    await tundaSebentar(600);              // tunggu 600ms
    const response = await fetch(...);      // tunggu proses fetch
    const data = await response.json();     // tunggu proses parsing JSON
    renderDivisi(tbody, data);
}
```

- Fungsi yang di dalamnya ada `await` harus ditandai `async` di depan `function`.
- `await` "menjeda" fungsi itu saja (bukan seluruh halaman) sampai proses di sebelah kanannya selesai.

## 4. Loading Indicator

Karena proses fetch butuh waktu (di jobsheet ini disimulasikan 600ms lewat `tundaSebentar()`), pengguna perlu tahu bahwa data sedang dimuat, bukan halamannya rusak/kosong. Makanya `<tbody>` diisi baris sementara saat halaman pertama kali dibuka:

```html
<tbody id="tabel-divisi-body">
    <tr id="loading-indicator">
        <td colspan="5">⏳ Memuat data divisi...</td>
    </tr>
</tbody>
```

Begitu `fetch()` selesai dan berhasil, `tbody.innerHTML = ''` mengosongkan baris loading ini, lalu baris data yang sesungguhnya dimasukkan menggantikannya.

## 5. Penanganan Error dengan `try/catch`

Fetch bisa gagal — misalnya nama file salah ketik, file terhapus, atau koneksi bermasalah. Kalau tidak ditangani, error ini akan bikin halaman diam tanpa penjelasan. `try/catch` menangkap error itu dan menampilkan pesan yang jelas:

```js
try {
    const response = await fetch('../data/divisi.json');
    if (!response.ok) {
        throw new Error('Server merespons dengan status ' + response.status);
    }
    // ...proses data...
} catch (error) {
    tbody.innerHTML = '<tr class="error-row"><td colspan="5">Gagal memuat data divisi: ' + error.message + '</td></tr>';
}
```

Kode di dalam `try` dijalankan seperti biasa. Kalau ada baris yang gagal (melempar error), eksekusi langsung lompat ke blok `catch`, dan pesan error ditampilkan di dalam tabel alih-alih halaman kosong/rusak.

## 6. Kenapa Konfirmasi Hapus Diubah ke Event Delegation?

Di Jobsheet 5, tombol Hapus sudah ada sejak HTML pertama dimuat, jadi `document.querySelectorAll('.btn-hapus')` bisa langsung menemukannya dan memasang `addEventListener` satu-satu.

Di Jobsheet 6, tombol Hapus baru muncul **setelah** `fetch()` selesai (600ms+ setelah halaman dimuat) — padahal `querySelectorAll` di dalam `DOMContentLoaded` sudah berjalan lebih dulu, sebelum tombolnya ada. Akibatnya, listener tidak pernah terpasang ke tombol yang baru dibuat.

Solusinya, **event delegation**: pasang satu listener di `document` (elemen yang sudah pasti ada sejak awal), lalu deteksi target klik pakai `closest()`:

```js
document.addEventListener('click', function (event) {
    const button = event.target.closest('.btn-hapus');
    if (!button) return;
    // ...proses hapus...
});
```

Karena klik selalu "menggelembung" (bubbling) dari elemen yang diklik sampai ke `document`, listener ini tetap terpanggil walau tombolnya baru dibuat kapan saja — termasuk tombol yang muncul dari hasil fetch.

## 7. Kenapa Harus Pakai Server Lokal? (CORS)

Browser modern menerapkan kebijakan keamanan bernama **CORS** (Cross-Origin Resource Sharing) yang memblokir `fetch()` ke file lokal kalau halaman dibuka langsung lewat `file://` (klik dua kali index.html). Solusinya, jalankan halaman lewat server lokal supaya alamatnya jadi `http://localhost:...`, misalnya:

```
php -S localhost:8000
```

lalu buka `http://localhost:8000/index.html`. Ekstensi "Live Server" di VSCode juga melakukan hal yang sama secara otomatis.

## 8. Rangkuman & Latihan Lanjutan

Ringkasan konsep yang dipelajari di jobsheet ini:

- JSON adalah format data terstruktur, dibaca sebagai array of object di JavaScript.
- `fetch()` mengambil data secara asinkron; `async`/`await` membuat kode asinkron mudah dibaca.
- Loading indicator memberi tahu pengguna bahwa data sedang diproses.
- `try/catch` menangkap error fetch supaya halaman tidak diam tanpa penjelasan.
- Event delegation diperlukan untuk elemen yang dibuat secara dinamis setelah halaman dimuat.
- `fetch()` ke file lokal butuh server lokal karena kebijakan CORS browser.

Latihan lanjutan yang bisa dicoba sendiri:

- Ubah nama file di `fetch('../data/divisi.json')` jadi salah (misalnya `divisii.json`), refresh halaman, dan amati pesan error yang muncul.
- Tambah satu objek baru di `data/anggota.json`, refresh halaman, dan lihat apakah baris barunya otomatis muncul di tabel tanpa mengedit HTML sama sekali.
- Coba ubah delay simulasi di `tundaSebentar(600)` menjadi 2000 (2 detik), amati loading indicator tampil lebih lama.
