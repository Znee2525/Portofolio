@extends('layouts.portfolio')
@section('title', $project['title'].' | Muhammad Zidane')
@section('content')
    <div class="shell standalone-quest"><a href="{{ route('portfolio') }}#quests" class="text-link"><x-icon name="arrow-left" /> Back to the quest archive</a><div class="standalone-quest-panel">@include('portfolio.partials.quest-content', ['titleId' => 'quest-title', 'standalone' => true])</div></div>
@endsection
