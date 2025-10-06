@props(['priority', 'classes' => '', 'iconsize' => 'sm', 'darkClass' => ''])

<span
    class="badge text-nowrap @if($priority === 'urgent' || $priority === 'immediate' || $priority === 'high')badge-error dark:badge-error @endif{{ !empty($darkClass) && $priority === 'urgent' || $priority === 'immediate' || $priority === 'high' ? " $darkClass" : 'dark:badge-neutral' }} {{ $classes }}">
    @if ($priority === 'urgent' || $priority === 'immediate' || $priority === 'high')
        <span class="icon icon-{{ $iconsize }} icon-alert-triangle me-1"></span>
    @endif
    {{ Str::ucfirst(str_replace('_', ' ', $priority)) }}
</span>