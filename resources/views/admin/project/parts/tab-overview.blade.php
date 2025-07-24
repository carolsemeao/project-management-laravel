@php
    $offers = App\Http\Controllers\OfferController::getOffersForProject($project->id);
    $recentOffer = $offers->take(1);
@endphp
<div class="row mt-3">
    <div class="col-6">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="card-title">Project information</h2>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="mb-1">
                            <strong class="text-muted small">{{ __('Status') }}</strong>
                            <p class="mb-0 mt-1">
                                <x-badge :label="ucfirst($project->status)"
                                    textColor="text-{{ $project->status === 'active' ? 'success' : ($project->status === 'planning' ? 'warning' : 'secondary') }}" />
                            </p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-1">
                            <strong class="text-muted small">{{ __('Created') }}</strong>
                            <p class="mb-0 mt-1">
                                <i data-feather="calendar" class="me-1" style="width: 14px; height: 14px;"></i>
                                {{ $project->created_at ? $project->created_at->format('d/m/Y') : __('Not set') }}
                            </p>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="mb-1">
                            <strong class="text-muted small">{{ __('Due Date') }}</strong>
                            <p class="mb-0 mt-1">
                                <i data-feather="calendar" class="me-1" style="width: 14px; height: 14px;"></i>
                                {{ $project->due_date ? $project->due_date->format('d/m/Y') : __('Not set') }}
                                @if($project->isOverdue())
                                    <x-badge :label="__('Overdue')" textColor="text-danger" classes="ms-1 small" />
                                @elseif($project->isDueSoon())
                                    <x-badge :label="__('Due Soon')" textColor="text-warning" classes="ms-1 small" />
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="mb-1">
                            <strong class="text-muted small">{{ __('Team Size') }}</strong>
                            <p class="mb-0 mt-1">
                                <i data-feather="users" class="me-1" style="width: 14px; height: 14px;"></i>
                                {{ __(':assignedMembers :members', ['assignedMembers' => $project->users()->count(), 'members' => Str::plural('member', $project->users()->count())]) }}
                                @if($project->isOverdue())
                                    <x-badge :label="__('Overdue')" textColor="text-danger" classes="ms-1 small" />
                                @elseif($project->isDueSoon())
                                    <x-badge :label="__('Due Soon')" textColor="text-warning" classes="ms-1 small" />
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-1">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <strong class="text-muted small">{{ __('Issue Completion') }}</strong>
                                <small class="text-muted">{{ $project->getProgressPercentage() }}%</small>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-dark" role="progressbar"
                                    style="width: {{ $project->getProgressPercentage() }}%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        @php
                            $timeProgress = $project->getCombinedTimeProgress();
                        @endphp
                        <div class="mb-1">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <strong class="text-muted small">{{ __('Time Progress') }}</strong>
                                <small class="text-muted">{{ $timeProgress['percentage'] }}%</small>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-dark" role="progressbar"
                                    style="width: {{ $timeProgress['percentage'] }}%"
                                    aria-valuenow="{{ $timeProgress['percentage'] }}" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                            <small class="text-muted">
                                {{ $timeProgress['issue_logged'] }} logged / {{ $timeProgress['total_estimated'] }}
                                estimated
                                <span class="text-primary">
                                    ({{ $timeProgress['issue_estimated'] }} from issues +
                                    {{ $timeProgress['offer_hours'] }} from offers)
                                </span>
                            </small>
                        </div>
                    </div>



                    <div class="col-12">
                        <div class="mt-2">
                            <h2>{{ __('Recent Offer') }}</h2>
                            @foreach($recentOffer as $offer)
                                <div class="card">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div>
                                            <h3>{{ $offer->name }}</h3>
                                            <small class="text-muted">{{ $offer->customer->company->name }} •
                                                {{ Str::ucfirst($offer->status) }}</small>
                                        </div>
                                        <div class="text-end">
                                            <strong>{{ $offer->getFormattedTotal() }}</strong>
                                            <small class="text-muted d-block">{{ $offer->getTotalHours() }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="card-title">Quick actions</h2>
                <div class="d-grid gap-2">
                    <x-button-primary btnType="dark" classes="w-100">
                        <i data-feather="edit" class="me-2" style="width: 16px; height: 16px;"></i>
                        {{ __('Edit project details') }}
                    </x-button-primary>
                    <x-button-primary btnType="outline-secondary"
                        classes="d-flex align-items-center justify-content-center"
                        furtherActions="data-bs-toggle=modal data-bs-target=#logTimeModal">
                        {{ __('Mark as complete') }}
                    </x-button-primary>
                    <x-button-primary btnType="outline-secondary"
                        classes="d-flex align-items-center justify-content-center"
                        furtherActions="data-bs-toggle=modal data-bs-target=#logTimeModal">
                        {{ __('Put on Hold') }}
                    </x-button-primary>
                    <x-button-primary btnType="outline-danger"
                        classes="d-flex align-items-center justify-content-center"
                        furtherActions="data-bs-toggle=modal data-bs-target=#logTimeModal">
                        <i data-feather="trash-2" class="me-2" style="width: 16px; height: 16px;"></i>
                        {{ __('Archive project') }}
                    </x-button-primary>
                </div>
            </div>
        </div>
    </div>
</div>