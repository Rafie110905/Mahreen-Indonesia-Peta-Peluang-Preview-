# Mahreen Indonesia — Peta Peluang (Prototype)

Prototype website untuk Creative Challenge Mahreen Indonesia Internship Batch 2 — posisi **Website Development**.

## Konsep
1. **Mulai Dari Mana (kuis singkat)** — pengunjung memilih bidang yang paling menarik minatnya, lalu website merekomendasikan program yang paling cocok (logika di `api/recommend.php`, dipanggil lewat `fetch()` di `assets/script.js`).
2. **Peta Peluang (grid program)** — seluruh program/peluang Mahreen Indonesia ditampilkan dalam satu grid yang bisa difilter per kategori, supaya informasi yang tadinya tersebar jadi mudah dijelajah.

## Struktur File
```
index.php              -> halaman utama (render PHP dari data program)
data/programs.php      -> "database" program dalam bentuk array PHP (edit di sini)
api/recommend.php      -> endpoint JSON untuk logika rekomendasi kuis
assets/style.css        -> semua styling (brand pink/magenta/coral gradient)
assets/script.js        -> logika kuis (fetch ke API) + filter grid
```

## Cara Menjalankan (butuh PHP terpasang)
```bash
php -S localhost:8000
```
Lalu buka http://localhost:8000 di browser.

## Catatan Penting
- Nama & deskripsi program di `data/programs.php` adalah **contoh ilustratif** mengikuti 6 bidang ekosistem yang disebut di brief (kreativitas, teknologi digital, pengembangan talenta, bisnis, komunitas, kontribusi sosial). **Ganti dengan nama program resmi Mahreen Indonesia** sebelum dipakai sebagai submission final — cukup edit array di `data/programs.php`, seluruh halaman (grid + kuis) akan otomatis ikut berubah.
- Semua warna mengikuti brand Mahreen Indonesia: gradient magenta → pink → coral seperti pada template logo resmi.
