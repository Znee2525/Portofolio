<header class="site-header">
    <div class="shell header-inner">
        <a href="{{ route('portfolio') }}" class="brand" aria-label="Muhammad Zidane, beranda"><span class="brand-mark"><x-icon name="clover" /></span><span>ZIDANE<span class="brand-period">.</span></span></a>
        <nav id="main-navigation" aria-label="Navigasi utama">
            @foreach (['profile' => 'Profile', 'attributes' => 'Attributes', 'quests' => 'Quests', 'missions' => 'Missions', 'academy' => 'Academy'] as $id => $label)
                <a href="{{ route('portfolio') }}#{{ $id }}" data-nav-section="{{ $id }}" aria-label="{{ $label }}">{{ $label }}</a>
            @endforeach
            <a href="{{ route('portfolio') }}#contact" class="nav-contact" data-nav-section="contact">Contact</a>
        </nav>
        <a class="header-record" href="{{ route('record.download') }}" aria-label="Character Record" @unless($cvAvailable) data-record @endunless><x-icon name="identification-card" /><span>Character Record</span><x-icon name="arrow-up-right" /></a>
        <button type="button" class="icon-button menu-toggle" aria-expanded="false" aria-controls="main-navigation" aria-label="Buka navigasi"><x-icon name="list" /></button>
    </div>
</header>
