@extends('layouts.portfolio')

@section('content')
    @include('portfolio.sections.hero')
    @include('portfolio.sections.profile')
    @include('portfolio.sections.projects')
    @include('portfolio.sections.attributes')
    @include('portfolio.sections.missions')
    @include('portfolio.sections.academy')
    @include('portfolio.sections.contact')
    @foreach ($portfolio['projects'] as $project)
        <dialog class="quest-dialog" id="quest-{{ $project['slug'] }}" aria-labelledby="dialog-{{ $project['slug'] }}">
            <div class="dialog-top"><span class="mono">QUEST ARCHIVE / {{ $project['category_label'] }}</span><button type="button" class="icon-button" data-close-dialog aria-label="Tutup detail proyek"><x-icon name="x" /></button></div>
            @include('portfolio.partials.quest-content', ['titleId' => 'dialog-'.$project['slug']])
        </dialog>
    @endforeach
@endsection
