<section id="contact" class="section contact-section">
    <div class="shell contact-grid">
        <div class="contact-art" aria-hidden="true"><div class="magic-circle circle-outer"></div><div class="magic-circle circle-inner"></div><div class="circle-diamond"></div><x-icon name="clover" class="contact-clover" /><span class="circle-star star-top">✧</span><span class="circle-star star-bottom">✧</span></div>
        <div class="contact-copy" data-reveal>
            <span class="section-kicker">Communication Magic Circle</span>
            <h2>Let's build<br><span class="text-gold">the next chapter.</span></h2>
            <p>Punya ide, pertanyaan teknis, atau peluang kolaborasi? Mulai percakapan melalui kanal yang tersedia.</p>
            <div class="contact-channels">
                @foreach ([['envelope-simple', 'Email', $portfolio['email'] ? 'mailto:'.$portfolio['email'] : null, $portfolio['email']], ['linkedin-logo', 'LinkedIn', $portfolio['linkedin'], null], ['github-logo', 'GitHub', $portfolio['github'], null]] as [$icon, $label, $url, $display])
                    @if ($url)
                        <a href="{{ $url }}" @if($label !== 'Email') target="_blank" rel="noopener noreferrer" @endif><x-icon :name="$icon" /><span>{{ $display ?: $label }}</span><x-icon name="arrow-up-right" /></a>
                    @else
                        <div class="contact-unavailable"><x-icon :name="$icon" /><span>{{ $label }}</span><small>Belum ditambahkan</small></div>
                    @endif
                @endforeach
            </div>
            @unless ($portfolio['email'] || $portfolio['github'] || $portfolio['linkedin'])<p class="fine-print">Kanal kontak pemilik belum tersedia. Informasi kontak akan tampil setelah ditambahkan.</p>@endunless
            <a href="{{ route('record.download') }}" class="text-link" @unless($cvAvailable) data-record @endunless>Get the Character Record <x-icon name="arrow-right" /></a>
        </div>
    </div>
</section>
