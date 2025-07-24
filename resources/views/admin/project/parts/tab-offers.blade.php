<div class="d-flex justify-content-between align-items-center my-3">
    <div>
        <h2>Project Offers</h2>
        @php
            $offers = App\Http\Controllers\OfferController::getOffersForProject($project->id);
            $offerCount = $offers->count();
        @endphp
        <small class="text-muted">
            {{ __(':numberOfOffers :offers', ['numberOfOffers' => $offerCount, 'offers' => Str::plural('offer', $offerCount)]) }}
        </small>
    </div>
    <a href="{{ route('admin.offer.admin_offers_create', ['project_id' => $project->id]) }}"
        class="btn btn-dark d-flex align-items-center justify-content-center">
        <i data-feather="plus" class="me-2" style="width: 16px; height: 16px;"></i>
        {{ __('New Offer') }}
    </a>
</div>

@if($offers->count() > 0)
    <div class="row">
        @foreach($offers as $offer)
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title mb-0">{{ $offer->name }}</h5>
                            <span
                                class="badge bg-{{ $offer->status === 'accepted' ? 'success' : ($offer->status === 'sent' ? 'primary' : ($offer->status === 'rejected' ? 'danger' : 'secondary')) }}">
                                {{ ucfirst($offer->status) }}
                            </span>
                        </div>

                        @if($offer->description)
                            <p class="card-text text-muted small">{{ Str::limit($offer->description, 80) }}</p>
                        @endif

                        <div class="mb-2">
                            <small class="text-muted">
                                <i data-feather="user" style="width: 12px; height: 12px;"></i>
                                {{ $offer->customer->name }}
                            </small>
                        </div>

                        @if($offer->valid_until)
                            <div class="mb-2">
                                <small class="text-muted">
                                    <i data-feather="calendar" style="width: 12px; height: 12px;"></i>
                                    Valid until: {{ $offer->valid_until->format('M j, Y') }}
                                </small>
                            </div>
                        @endif

                        <div class="mb-3">
                            <strong class="text-primary">{{ $offer->getFormattedTotal() }}</strong>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.offer.admin_offers_show', $offer) }}"
                                class="btn btn-sm btn-outline-primary flex-fill">
                                View
                            </a>
                            @if($offer->status === 'draft')
                                <a href="{{ route('admin.offers.edit', $offer) }}" class="btn btn-sm btn-outline-secondary">
                                    Edit
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="text-center py-5">
        <i data-feather="file-text" class="text-muted mb-3" style="width: 48px; height: 48px;"></i>
        <h5 class="text-muted">No offers yet</h5>
        <p class="text-muted">Create your first offer for this project.</p>
        <a href="{{ route('admin.offer.admin_offers_create', ['project_id' => $project->id]) }}" class="btn btn-primary">
            <i data-feather="plus" class="me-2" style="width: 16px; height: 16px;"></i>
            Create First Offer
        </a>
    </div>
@endif