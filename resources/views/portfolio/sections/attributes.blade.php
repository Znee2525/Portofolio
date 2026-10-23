<section id="attributes" class="section attributes-section">
    <div class="shell">
        <x-section-heading title="Magic Attributes" subtitle="A skill tree rooted in real projects." data-reveal />
        <div class="attributes-layout" data-reveal>
            <div class="skill-tree" aria-label="Pilih cabang keterampilan">
                <div class="tree-root" aria-hidden="true"><x-icon name="clover" /><span>ENGINEERING</span></div>
                <div class="tree-branches" role="tablist" aria-label="Cabang keterampilan" aria-orientation="vertical">
                    @foreach ($portfolio['attributes'] as $attribute)
                        <button type="button" class="skill-node" id="tab-{{ $attribute['id'] }}" role="tab" aria-controls="attribute-{{ $attribute['id'] }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}" tabindex="{{ $loop->first ? '0' : '-1' }}"><span class="node-icon"><x-icon :name="$attribute['icon']" /></span><span>{{ $attribute['label'] }}</span><x-icon name="caret-right" /></button>
                    @endforeach
                </div>
                <p class="fine-print">Select an attribute to explore its technologies.</p>
            </div>
            <div class="attribute-panels grimoire-panel">
                @foreach ($portfolio['attributes'] as $attribute)
                    <div id="attribute-{{ $attribute['id'] }}" class="attribute-panel" role="tabpanel" aria-labelledby="tab-{{ $attribute['id'] }}" tabindex="0" @unless($loop->first) hidden @endunless>
                        <x-icon :name="$attribute['icon']" class="attribute-icon" />
                        <span class="mono text-gold">{{ $attribute['label'] }}</span>
                        <h3>{{ $attribute['title'] }}</h3>
                        <p>{{ $attribute['description'] }}</p>
                        <div class="attribute-skills flex flex-wrap gap-2">@foreach ($attribute['skills'] as $skill)<span><x-icon name="diamond" />{{ $skill }}</span>@endforeach</div>
                        <a class="text-link" href="{{ route('quests.show', $attribute['quest']) }}" data-quest="{{ $attribute['quest'] }}">Explore related quest <x-icon name="arrow-up-right" /></a>
                        <p class="fine-print">Teknologi yang dieksplorasi dalam proyek pilihan.</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
