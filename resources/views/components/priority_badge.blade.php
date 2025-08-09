@props(['priority'])

@php
    $badgeClass = match ($priority) {
        'low' => 'text-success',
        'high' => 'text-warning',
        'urgent' => 'text-danger',
        'immediate' => 'text-danger',
        default => 'text-secondary'
    };
@endphp
<span class="badge {{ $badgeClass }} d-inline-flex align-items-center fw-bold">
    @if ($priority === 'urgent' || $priority === 'immediate')
        <span class="icon icon-sm icon-alert-triangle me-1"></span>
    @endif
    {{ Str::ucfirst(str_replace('_', ' ', $priority)) }}
</span>