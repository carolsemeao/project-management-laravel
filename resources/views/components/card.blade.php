@props(['icon' => null])

<div class="stat bg-base-200/20 dark:bg-neutral/30">
    @if ($icon)
        <div class="stat-figure text-secondary">
            <span class="icon icon-lg icon-{{ $icon }}"></span>
        </div>
    @endif
    <div class="stat-title">{{ $title }}</div>
    <div class="stat-value text-primary">{{ $text }}</div>
    <div class="stat-desc">{{ $subtitle }}</div>
</div>