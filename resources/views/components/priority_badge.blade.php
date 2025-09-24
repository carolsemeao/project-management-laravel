@props(['priority'])

<span class="badge @if ($priority === 'urgent' || $priority === 'immediate')badge--icon @endif">
    @if ($priority === 'urgent' || $priority === 'immediate')
        <span class="icon icon-sm icon-alert-triangle me-1"></span>
    @endif
    {{ Str::ucfirst(str_replace('_', ' ', $priority)) }}
</span>