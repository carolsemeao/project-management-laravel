@if ($type === 'active')
    <div class="inline-grid *:[grid-area:1/1]">
        <div class="status status-primary animate-ping {{ $sizeClass }}"></div>
        <div class="status status-primary {{ $sizeClass }}"></div>
    </div>
@else
    <div class="status {{ $statusClass }} {{ $sizeClass }}" aria-label="status"></div>
@endif