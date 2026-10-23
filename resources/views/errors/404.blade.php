@php
    $portfolio = config('portfolio');
    $cvAvailable = \Illuminate\Support\Facades\Storage::disk('public')->exists('muhammad-zidane-cv.pdf');
@endphp

@extends('layouts.portfolio')
@section('title', 'Quest not found | Muhammad Zidane')
@section('content')
    <section class="shell flex min-h-[65dvh] flex-col items-center justify-center gap-6 py-24 text-center">
        <x-icon name="clover" class="record-icon" />
        <span class="mono text-gold">404 / QUEST NOT FOUND</span>
        <h1 class="font-display text-4xl">This quest is uncharted.</h1>
        <p class="max-w-md text-sm text-parchment/70">Halaman yang Anda cari belum ada dalam grimoire ini. Kembali ke arsip untuk menjelajahi proyek yang tersedia.</p>
        <a href="{{ route('portfolio') }}#quests" class="button button-primary"><x-icon name="arrow-left" /> Back to the quests</a>
    </section>
@endsection
