@props(['btnType' => 'primary', 'classes' => '', 'furtherActions' => '', 'isLink' => false, 'href' => ''])

@php
    $buttonClasses = [
        'primary' => 'btn-primary',
        'secondary' => 'btn-secondary',
        'success' => 'btn-success',
        'danger' => 'btn-error',
        'warning' => 'btn-warning',
        'info' => 'btn-info',
        'light' => 'btn-ghost',
        'dark' => 'btn-neutral',
        'link' => 'btn-link',
        'outline-primary' => 'btn-outline btn-primary',
        'outline-secondary' => 'btn-outline btn-secondary',
    ];
    $btnClass = $buttonClasses[$btnType] ?? 'btn-primary';
@endphp

@if ($isLink)
    <a class="btn {{ $btnClass }} {{ $classes }}" {{ $furtherActions }} href="{{ $href }}">{{ $slot }}</a>
@else
    <button class="btn {{ $btnClass }} {{ $classes }}" {{ $furtherActions }}>{{ $slot }}</button>
@endif