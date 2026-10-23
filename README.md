# Muhammad Zidane | A Developer's Grimoire

Portfolio personal bertema dark fantasy RPG, terinspirasi atmosfer Black Clover. Implementasi menggunakan Laravel 13, Blade, Tailwind CSS 4, dan JavaScript tanpa framework UI tambahan.

## Menjalankan

Prasyarat: PHP 8.3+ (pengembangan memakai PHP 8.4), Composer, dan Node.js yang didukung Vite 8.

```powershell
composer install
npm install --offline=false
Copy-Item .env.example .env  # hanya jika .env belum tersedia
php artisan key:generate    # hanya pada instalasi baru
php artisan migrate
npm run build
php artisan serve --host=127.0.0.1 --port=8017
```

Buka `http://127.0.0.1:8017`. Untuk mengembangkan CSS/JS dengan hot reload, jalankan `npm run dev` pada terminal kedua. Jangan mengganti `.env` atau APP_KEY instalasi yang sudah digunakan.

## Konten yang perlu dilengkapi

Semua data proyek dan skill berada di `config/portfolio.php`. Empat proyek berasal dari brief pemilik. Hasil, tanggal, peran, detail implementasi, repository, dan live demo yang belum diberikan dijelaskan secara eksplisit, tanpa klaim performa atau link rekaan. Mission Log saat ini berisi pembelajaran berbasis proyek, bukan riwayat pekerjaan yang belum tersedia.

Tambahkan kanal kontak di `.env`:

```dotenv
PORTFOLIO_EMAIL=
PORTFOLIO_GITHUB=
PORTFOLIO_LINKEDIN=
```

Isi dengan alamat email milik pemilik dan URL HTTPS profil yang benar. Kanal yang belum diisi tampil sebagai keterangan, bukan link kosong. Jika memakai config cache, jalankan `php artisan config:clear` setelah mengubah data.

Untuk mengaktifkan CV asli, simpan PDF di `storage/app/public/muhammad-zidane-cv.pdf`. Tombol Download CV otomatis mengunduh file tersebut. Selama PDF belum tersedia, dialog menjelaskan keadaan ini dan menyediakan Character Record dalam `.txt`, yang diberi label sebagai ringkasan, bukan CV lengkap. Tidak diperlukan `storage:link` untuk download ini.

## Struktur

- `app/Http/Controllers/PortfolioController.php`: beranda, halaman detail quest, dan unduhan CV/ringkasan.
- `config/portfolio.php`: sumber data proyek, atribut, dan kontak.
- `routes/web.php`: tiga route bernama.
- `resources/views/layouts/portfolio.blade.php`: metadata, aset, layout global, dan dialog Character Record.
- `resources/views/portfolio/sections/`: hero, profile, projects, attributes, missions, academy, contact.
- `resources/views/portfolio/partials/`: navigasi, footer, dan detail proyek yang digunakan ulang pada modal dan halaman mandiri.
- `resources/views/components/`: ikon dan section heading reusable.
- `resources/css/app.css`: design tokens dan komponen visual, breakpoint, reduced motion, serta print styles.
- `resources/js/app.js`: GSAP/ScrollTrigger, filter, dialog, mobile navigation, skill tabs, dan kontrol partikel.
- `public/images/`: ilustrasi WebP lokal dan favicon.
- `tests/Feature/PortfolioTest.php`: kontrak halaman, detail, 404, escaping, serta kedua kondisi unduhan.

## Design system

Warna: charcoal `#101012`, surface `#171719`, crimson `#b72c40`, parchment gold `#c9b383`, teks `#eeeae3`. Cinzel dipakai untuk judul bertema grimoire; Manrope untuk konten teknis; IBM Plex Mono untuk metadata. Seluruh font di-host lokal melalui Fontsource. Ikon memakai keluarga Phosphor regular.

Spacing menggunakan kelipatan 4/8 px. Radius panel 3 px; garis tipis berwarna parchment; crimson glow dibatasi untuk umpan balik. Motion memakai durasi 180 ms untuk feedback, 300-450 ms untuk perpindahan UI, sekitar 750 ms untuk reveal, dan 1.5 detik untuk intro buku. Easing utama `cubic-bezier(.16,1,.3,1)` / GSAP `power3.out`.

Intro grimoire tidak mengunci navigasi. Partikel/rune berjalan terbatas dan memiliki kontrol Ambient motion. Tidak ada audio. `prefers-reduced-motion` mematikan animasi otomatis; pergantian preferensi saat halaman terbuka juga ditangani. Filter memberi result count; skill tree mendukung panah atas/bawah, Home, End, Enter, dan Tab. Dialog memakai fokus native, Escape, serta pengembalian fokus. Tanpa JavaScript, tautan quest membuka halaman server-rendered dan seluruh atribut tetap terbaca.

## Aset dan asalnya

Lima ilustrasi orisinal dibuat dengan built-in ImageGen untuk proyek ini. Tidak memakai screenshot anime, logo resmi, foto perangkat yang diklaim nyata, atau screenshot hasil proyek. Ilustrasi proyek diberi label Concept artwork. Black Clover menjadi referensi atmosfer, bukan afiliasi resmi.

Set prompt (ringkasan spesifikasi):

1. `clover-kingdom.webp`: panorama anime dark fantasy orisinal, kastil gothic dan bulan keemasan di kanan, ksatria berjubah hitam dengan pedang anti-magic dan grimoire, ruang kiri gelap untuk teks, palet charcoal/crimson/parchment, tanpa tulisan atau logo.
2. `qris.webp`: globe wireframe emas, database abstrak dan koneksi data pembayaran Asia Tenggara, pencahayaan crimson, tanpa dashboard atau angka rekaan.
3. `buoy.webp`: ilustrasi smart buoy merah di laut gelap, sensor mast, antena dan cincin sinyal halus, tanpa klaim perangkat nyata.
4. `air.webp`: konsep sensor kualitas udara dan ponsel tanpa UI nyata, aliran udara keemasan dan ruang charcoal.
5. `tracking.webp`: siluet manusia wireframe emas, node skeletal tracking crimson, ruang virtual minimal, tanpa screenshot software.

WebP desktop/mobile dibuat dari output asli dengan PHP GD. Total enam file WebP sekitar 494 KB. Hero desktop sekitar 161 KB, versi mobile sekitar 59 KB. Hero diprioritaskan; gambar proyek dimuat secara lazy. Sumber PNG hero disimpan secara privat di `storage/app/private/portfolio-qa/` dan tidak dibutuhkan saat runtime.

## Dependensi dan verifikasi

Tambahan frontend: `gsap`, `@phosphor-icons/web`, `@fontsource/cinzel`, `@fontsource/manrope`, `@fontsource/ibm-plex-mono`. Laravel Boost ditambahkan sebagai dev dependency sesuai AGENTS.md dan panduannya telah dihasilkan. Tidak memakai React, Vue, Three.js, atau library scroll hijacking.

Composer memakai autoload PSR standar (`optimize-autoloader: false`) karena proses optimasi autoload lokal macet. Instalasi dependensi tetap lengkap. Untuk deployment, optimasi dapat dievaluasi ulang di environment tujuan.

```powershell
npm run build
php artisan test --compact tests/Feature/PortfolioTest.php
php vendor/bin/pint --format agent app/Http/Controllers/PortfolioController.php config/portfolio.php routes/web.php tests/Feature/PortfolioTest.php
```

Build produksi dan enam test fitur lulus. Browser QA mencakup navigasi, filter, modal, fokus, dan skill tabs. Skor Lighthouse/Core Web Vitals produksi belum diukur.
