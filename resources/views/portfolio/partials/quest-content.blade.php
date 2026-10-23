<div class="quest-detail-content">
    <figure class="detail-figure"><img src="{{ asset('images/'.$project['image'].'.webp') }}" width="1000" height="563" alt="{{ $project['alt'] }}" loading="lazy"><figcaption>Ilustrasi konsep orisinal. Bukan dokumentasi perangkat atau screenshot hasil proyek.</figcaption></figure>
    <div class="detail-body"><span class="mono text-gold">{{ $project['category_label'] }}</span>
        @if ($standalone ?? false)
            <h1 id="{{ $titleId }}">{{ $project['title'] }}</h1>
        @else
            <h2 id="{{ $titleId }}">{{ $project['title'] }}</h2>
        @endif
        <p class="detail-summary">{{ $project['summary'] }}</p><div class="tech-list flex flex-wrap gap-2">@foreach ($project['technologies'] as $technology)<span>{{ $technology }}</span>@endforeach</div>
        <div class="detail-sections grid grid-cols-1 md:grid-cols-2 gap-8"><section><h3><x-icon name="crosshair" /> The problem</h3><p>{{ $project['problem'] }}</p></section><section><h3><x-icon name="lightbulb" /> The approach</h3><p>{{ $project['solution'] }}</p></section></div>
        <section class="implementation-section"><h3><x-icon name="code" /> Implementation notes</h3><div class="implementation-grid">@foreach ($project['implementation'] as [$title, $description])<div><h4>{{ $title }}</h4><p>{{ $description }}</p></div>@endforeach</div></section>
        <section class="challenge-section"><h3><x-icon name="mountains" /> Challenges & evaluation</h3><p>{{ $project['challenge'] }}</p></section>
        <section class="result-section"><h3><x-icon name="seal-check" /> Known results</h3><p>{{ $project['result'] }}</p></section>
        <div class="quest-source-links">
            @if ($project['github'])<a href="{{ $project['github'] }}" class="button button-secondary" target="_blank" rel="noopener noreferrer"><x-icon name="github-logo" /> GitHub <x-icon name="arrow-up-right" /></a>@endif
            @if ($project['demo'])<a href="{{ $project['demo'] }}" class="button button-primary" target="_blank" rel="noopener noreferrer">Live demo <x-icon name="arrow-up-right" /></a>@endif
            @unless ($project['github'] || $project['demo'])<p class="fine-print"><x-icon name="link" /> Repository dan live demo belum ditambahkan.</p>@endunless
            <a class="text-link" href="{{ route('quests.show', $project['slug']) }}" data-permalink>Permanent quest link <x-icon name="arrow-up-right" /></a>
        </div>
    </div>
</div>
