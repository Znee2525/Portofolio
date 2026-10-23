@props(['name'])
<i {{ $attributes->merge(['class' => 'ph ph-'.$name]) }} aria-hidden="true"></i>
