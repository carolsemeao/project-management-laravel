@props(['label', 'classes' => '', 'darkClass' => ''])

<span
    class="badge text-nowrap badge-sm {{ !empty($darkClass) ? " $darkClass" : 'dark:badge-neutral' }} {{ $classes ?? '' }}">
    {{ $slot }}
    {{ $label }}
</span>