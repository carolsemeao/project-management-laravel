<div class="flex justify-end items-center mb-6">
    <a href="{{ route('admin.offer.admin_offers_create', ['project_id' => $project->id]) }}" class="btn">
        <span class="icon icon-sm icon-plus me-2"></span>
        {{ __('New Offer') }}
    </a>
</div>

@if($offers->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($offers as $offer)
            <div class="card h-full">
                <div class="card-body">
                    <div class="flex justify-between items-start mb-1">
                        <h3 style="margin-bottom: 0;">{{ $offer->name }}</h3>
                        <x-badge class="badge badge-sm badge-dash" :label="ucfirst($offer->status)" />
                    </div>

                    @if($offer->description)
                        <p class="opacity-70 text-xs">{{ Str::limit($offer->description, 80) }}</p>
                    @endif

                    <div class="flex flex-col gap-2 my-3">
                        <p class="opacity-70 text-xs">
                            <span class="icon icon-xs icon-user me-2"></span>
                            {{ $offer->customer->name }}
                        </p>
                        @if($offer->valid_until)
                            <p class="opacity-70 text-xs">
                                <span class="icon icon-xs icon-calendar me-2"></span>
                                {{ __('Valid until: :date', ['date' => $offer->valid_until->format('d.m.Y')]) }}
                            </p>
                        @endif
                    </div>

                    <div class="flex justify-between items-center flex-wrap">
                        <p class="text-primary text-lg font-bold">{{ $offer->getFormattedTotal() }}</p>
                        <div class="card-actions">
                            <a href="{{ route('admin.offer.admin_offers_show', $offer) }}" class="btn btn-sm dark:btn-neutral">
                                {{ __('View') }}
                            </a>
                            @if($offer->status === 'draft')
                                <a href="{{ route('admin.offers.edit', $offer) }}" class="btn btn-sm btn-outline">
                                    {{ __('Edit') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="empty">
        <span class="icon icon-lg icon-file-text mb-2 block"></span>
        <p class="text-sm">{{ __('No offers found') }}</p>
        <p class="text-xs mt-1">{{ __('Create your first offer for this project') }}</p>
        <a href="{{ route('admin.offer.admin_offers_create', ['project_id' => $project->id]) }}" class="btn mt-3">
            <span class="icon icon-sm icon-plus me-2"></span>
            {{ __('Create First Offer') }}
        </a>
    </div>
@endif