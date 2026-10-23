<section id="quests" class="section quests-section">
    <div class="section-slash" aria-hidden="true"></div>
    <div class="shell">
        <x-section-heading title="Completed Quests" subtitle="Selected projects / Data, devices & digital worlds" data-reveal />
        <div class="quest-toolbar" data-reveal>
            <div class="quest-filters flex flex-wrap gap-2" role="group" aria-label="Filter kategori proyek">
                @foreach (['all' => 'All quests', 'data' => 'Data & Automation', 'iot' => 'Embedded & IoT', 'interactive' => 'AI & Interactive'] as $value => $label)
                    <button type="button" class="filter-button" data-filter="{{ $value }}" aria-pressed="{{ $loop->first ? 'true' : 'false' }}">{{ $label }}</button>
                @endforeach
            </div>
            <span id="quest-count" class="mono" role="status">4 quests in the archive</span>
        </div>
        <div class="quest-grid grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ($portfolio['projects'] as $project)
                <article class="quest-card" data-category="{{ $project['category'] }}" data-reveal>
                    <a href="{{ route('quests.show', $project['slug']) }}" data-quest="{{ $project['slug'] }}" class="quest-image-link" aria-label="Buka detail {{ $project['title'] }}">
                        <img src="{{ asset('images/'.$project['image'].'.webp') }}" width="1000" height="563" alt="{{ $project['alt'] }}" loading="lazy" decoding="async">
                        <span class="quest-seal" aria-hidden="true"><x-icon name="clover" /></span>
                        <span class="quest-image-arrow" aria-hidden="true"><x-icon name="arrow-up-right" /></span>
                    </a>
                    <div class="quest-card-body">
                        <div class="quest-category"><x-icon :name="$project['icon']" /><span>{{ $project['category_label'] }}</span><span class="concept-label">Concept artwork</span></div>
                        <h3><a href="{{ route('quests.show', $project['slug']) }}" data-quest="{{ $project['slug'] }}">{{ $project['title'] }}</a></h3>
                        <p>{{ $project['summary'] }}</p>
                        <div class="tech-list flex flex-wrap gap-2">@foreach ($project['technologies'] as $technology)<span>{{ $technology }}</span>@endforeach</div>
                        <a href="{{ route('quests.show', $project['slug']) }}" data-quest="{{ $project['slug'] }}" class="quest-details">Open quest details <x-icon name="arrow-right" /></a>
                    </div>
                </article>
            @endforeach
        </div>
        <p class="archive-note"><x-icon name="info" /> Arsip proyek pilihan. Status rilis dan hasil terukur dijelaskan pada setiap detail proyek.</p>
    </div>
</section>
