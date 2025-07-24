@props(['priority'])

@php
    $badgeClass = match (strtolower($priority)) {
        'low' => 'text-success',
        'high' => 'text-warning',
        'urgent' => 'text-danger',
        'immediate' => 'text-danger',
        default => 'text-secondary'
    };
@endphp
<span class="badge {{ $badgeClass }}">
    @if ($priority === 'urgent' || $priority === 'immediate')
        <i class="bi bi-exclamation-triangle"></i>
    @endif
    {{ ucfirst($priority) }}
</span>