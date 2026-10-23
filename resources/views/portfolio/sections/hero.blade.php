<section class="hero" aria-labelledby="hero-name">
    <picture class="hero-picture">
        <source media="(max-width: 640px)" srcset="{{ asset('images/clover-kingdom-mobile.webp') }}">
        <img src="{{ asset('images/clover-kingdom.webp') }}" width="1680" height="945" alt="Ilustrasi anime orisinal seorang ksatria dengan grimoire dan pedang berenergi crimson di hadapan kastil kerajaan." fetchpriority="high" decoding="async">
    </picture>
    <div class="hero-shade" aria-hidden="true"></div>
    <div class="hero-particles" aria-hidden="true">
        @for ($i = 0; $i < 16; $i++)<span style="--particle: {{ $i }}"></span>@endfor
        <b class="floating-rune rune-one">✧</b><b class="floating-rune rune-two">◇</b><b class="floating-rune rune-three">✦</b>
    </div>
    <div class="shell hero-inner">
        <div class="hero-copy">
            <div class="hero-eyebrow" data-hero-reveal><span></span> A DEVELOPER'S GRIMOIRE</div>
            <h1 id="hero-name" data-hero-reveal>Muhammad<br><span>Zidane<span class="name-period">.</span></span></h1>
            <p class="hero-role" data-hero-reveal>Computer Engineering Student<br><span>at Institut Teknologi Sepuluh Nopember (ITS)</span></p>
            <p class="hero-tagline" data-hero-reveal>Building systems, one quest at a time.</p>
            <div class="hero-actions flex flex-wrap gap-3" data-hero-reveal>
                <a class="button button-primary" href="#quests"><x-icon name="sword" /> View Projects <x-icon name="arrow-up-right" /></a>
                <a class="button button-secondary" href="{{ route('record.download') }}" @unless($cvAvailable) data-record @endunless><x-icon name="download-simple" /> Download CV</a>
            </div>
        </div>
        <div class="hero-book" aria-hidden="true"><span class="book-page page-left"><x-icon name="clover" /></span><span class="book-page page-right"><span></span><span></span><span></span></span></div>
    </div>
    <div class="hero-bottom shell">
        <span class="hero-signature"><x-icon name="clover" /> Fueled by curiosity. Forged through code.</span>
        <button type="button" class="ambient-toggle" aria-pressed="false"><x-icon name="sparkle" /><span>Ambient motion</span><span class="toggle-track" aria-hidden="true"></span></button>
    </div>
</section>
