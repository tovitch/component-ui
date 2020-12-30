<span {{ $attributes->merge(['class' => $classes(), 'style' => $styles()]) }}
>{{ $text ? str_repeat('_', $size) : '' }}</span>
