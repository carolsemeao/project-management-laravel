@props(['label', 'textColor' => 'text-dark', 'classes' => 'bg-light'])

<span class="badge {{ $textColor }} {{ $classes }}">{{ $label }}</span>