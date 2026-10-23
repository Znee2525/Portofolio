@props(['title', 'subtitle' => null])
<div {{ $attributes->merge(['class' => 'section-heading']) }}>
    <div class="heading-ornament" aria-hidden="true"><span></span><x-icon name="clover" /><span></span></div>
    <h2>{{ $title }}</h2>
    @if ($subtitle)<p>{{ $subtitle }}</p>@endif
    {{ $slot }}
</div>
