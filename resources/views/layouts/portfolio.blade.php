<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#101012">
    <meta name="description" content="Portfolio Muhammad Zidane, mahasiswa Teknik Komputer ITS. Jelajahi proyek data, embedded systems, IoT, mobile, dan computer vision.">
    <meta property="og:title" content="Muhammad Zidane | A Developer's Grimoire">
    <meta property="og:description" content="Building systems, one quest at a time. Portfolio Teknik Komputer, Institut Teknologi Sepuluh Nopember.">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ asset('images/clover-kingdom.webp') }}">
    <title>@yield('title', "Muhammad Zidane | A Developer's Grimoire")</title>
    <link rel="icon" type="image/png" href="{{ asset('images/clover-mark.png') }}">
    @if (request()->routeIs('portfolio'))
        <link rel="preload" as="image" href="{{ asset('images/clover-kingdom.webp') }}" imagesrcset="{{ asset('images/clover-kingdom-mobile.webp') }} 840w, {{ asset('images/clover-kingdom.webp') }} 1680w" imagesizes="100vw" fetchpriority="high">
    @endif
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <a class="skip-link" href="#main">Lewati ke konten</a>
    @include('portfolio.partials.navigation')
    <main id="main">@yield('content')</main>
    @include('portfolio.partials.footer')
    @unless ($cvAvailable)
        <dialog class="record-dialog" id="character-record" aria-labelledby="record-title">
            <div class="dialog-top"><span class="mono">CHARACTER RECORD</span><button type="button" class="icon-button" data-close-dialog aria-label="Tutup Character Record"><x-icon name="x" /></button></div>
            <x-icon name="book-open" class="record-icon" />
            <h2 id="record-title">The story so far.</h2>
            <p>CV lengkap belum ditambahkan. Anda dapat mengunduh ringkasan profil dan teknologi proyek dari informasi yang tersedia.</p>
            <a href="{{ route('record.download') }}" class="button button-primary"><x-icon name="download-simple" /> Unduh ringkasan (.txt)</a>
            <p class="fine-print">Ringkasan ini bukan CV lengkap. Riwayat kerja, tanggal, dan metrik proyek belum tersedia.</p>
        </dialog>
    @endunless
    <div id="toast" class="toast" role="status" aria-live="polite"></div>
</body>
</html>
