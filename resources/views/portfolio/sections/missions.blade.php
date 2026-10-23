<section id="missions" class="section missions-section">
    <div class="section-slash" aria-hidden="true"></div>
    <div class="shell missions-grid">
        <div class="mission-intro" data-reveal><span class="section-kicker">Experience through exploration</span><h2>Magic Knight<br><span class="text-gold">Mission Log.</span></h2><p>Jejak pembelajaran melalui proyek. Riwayat pekerjaan, organisasi, peran, dan tanggal belum ditambahkan.</p><div class="mission-note"><x-icon name="scroll" /><span>Every system starts<br>with a question.</span></div></div>
        <div class="mission-timeline">
            <div class="timeline-energy" aria-hidden="true"></div>
            @foreach ([['database', 'Data & automation', 'QRIS Cross-Border Analysis', 'Menjelajahi database, orkestrasi alur data, container, dan analitik.', 'qris-cross-border'], ['waves', 'Connected devices', 'Smart Buoy & Air Quality', 'Menghubungkan mikrokontroler, sensor, komunikasi, dan antarmuka mobile.', 'smart-buoy'], ['cube', 'Interactive systems', 'Unity AI Body Tracking', 'Mengeksplorasi hubungan pose estimation dengan dunia interaktif.', 'unity-ai-body-tracking']] as [$icon, $label, $title, $description, $slug])
                <article class="mission-entry" data-reveal><span class="timeline-icon"><x-icon :name="$icon" /></span><span class="mono text-gold">{{ $label }}</span><h3>{{ $title }}</h3><p>{{ $description }}</p><a href="{{ route('quests.show', $slug) }}" data-quest="{{ $slug }}" class="text-link">Read the quest <x-icon name="arrow-up-right" /></a></article>
            @endforeach
        </div>
    </div>
</section>
