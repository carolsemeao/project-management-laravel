<div class="card mb-6">
    <div class="card-body">
        <h2 class="card-title mb-4">{{ __('Quick Stats') }}</h2>

        <p class="flex justify-between items-center mb-2">
            <span class="text-xs font-semibold">{{ __('Status') }}</span>
            @php $badgeLabel = $company->status ? __('Active') : __('Inactive');@endphp
            <x-badge :label="$badgeLabel" classes="badge-xs" />
        </p>

        <p class="flex justify-between items-center mb-2">
            <span class="text-xs font-semibold">{{ __('Total Projects') }}</span>
            <x-badge :label="count($company->projects)" classes="badge-xs" />
        </p>

        <p class="flex justify-between items-center mb-2">
            <span class="text-xs font-semibold">{{ __('Customer Since') }}</span>
            <span class="text-xs">{{ $company->created_at->format('d.m.Y') }}</span>
        </p>
    </div>
</div>