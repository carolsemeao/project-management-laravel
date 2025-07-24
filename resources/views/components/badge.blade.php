@props(['label', 'textColor' => 'text-dark', 'classes' => ''])

<span class="badge bg-light {{ $textColor }} {{ $classes }}">{{ $label }}</span>