<div class="md:grid md:grid-cols-12 gap-4">
    <div class="md:col-span-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-3 gap-y-4 mb-5">
            <div>
                <h3>{{ __('Status') }}</h3>
                <p class="mb-0 mt-1">
                    <x-badge :label="$project->getFormattedStatusName()" />
                </p>
            </div>
            <div>
                <h3>{{ __('Created') }}</h3>
                <p class="mb-0 mt-1">
                    <span class="icon icon-xs icon-calendar me-1"></span>
                    {{ $project->created_at ? $project->created_at->format('d/m/Y') : __('Not set') }}
                </p>
            </div>
            <div>
                <h3>{{ __('Due Date') }}</h3>
                <p class="mb-0 mt-1">
                    <span class="icon icon-xs icon-calendar me-1"></span>
                    {{ $project->due_date ? $project->due_date->format('d/m/Y') : __('Not set') }}
                    @if($project->isOverdue())
                        <x-badge :label="__('Overdue')" textColor="text-danger" classes="ms-1 small" />
                    @elseif($project->isDueSoon())
                        <x-badge :label="__('Due Soon')" textColor="text-warning" classes="ms-1 small" />
                    @endif
                </p>
            </div>
            <div>
                <h3>{{ __('Team Size') }}</h3>
                <p class="mb-0 mt-1">
                    <span class="icon icon-xs icon-users me-1"></span>
                    {{ __(':assignedMembers :members', ['assignedMembers' => $project->users()->count(), 'members' => Str::plural('member', $project->users()->count())]) }}
                </p>
            </div>
            <div>
                <h3>{{ __('Customer') }}</h3>
                <p class="mb-0 mt-1">
                    <span class="icon icon-xs icon-buildings me-1"></span>
                    {{ $project->company->name ?? __('Not set') }}
                </p>
            </div>
            <div>
                <h3>{{ __('Contact') }}</h3>
                <p class="mb-0 mt-1">
                    <span class="icon icon-xs icon-user me-1"></span>
                    {{ $project->customer->name ?? __('Not set') }}
                </p>
            </div>
        </div>
        <div class="mb-5">
            <h3>{{ __('Issue Completion') }}</h3>
            <span class="text-xs mb-1 opacity-70">
                {{ __(':timePercentage % complete', ['timePercentage' => $project->getProgressPercentage()]) }}
            </span>
            <progress class="progress" value="{{ $project->getProgressPercentage() }}" max="100"></progress>
        </div>
        <div class="mb-5">
            <h3>{{ __('Time Progress') }}</h3>
            <span class="text-xs mb-1 opacity-70">{{ $timeProgress['percentage'] }}%</span>
            <progress class="progress" value="{{ $timeProgress['percentage'] }}" max="100"></progress>
            <span class="opacity-70 text-xs">
                {{ __(':issueLogged logged / :totalEstimated estimated', ['issueLogged' => $timeProgress['issue_logged'], 'totalEstimated' => $timeProgress['total_estimated']]) }}
                <span class="text-accent-content dark:text-primary">
                    {{ __('(:issueEstimated from issues + :offerHours from offers)', ['issueEstimated' => $timeProgress['issue_estimated'], 'offerHours' => $timeProgress['offer_hours']]) }}
                </span>
            </span>
        </div>
        <div class="divider my-7"></div>
        @if($recentOffer->count() > 0)
            <h3>{{ __('Recent Offer') }}</h3>
            @foreach($recentOffer as $offer)
                <div class="card mt-3 bg-base-200/50">
                    <div class="card-body justify-between items-center flex-row">
                        <div>
                            <h4>{{ $offer->name }}</h4>
                            <p class="text-xs opacity-70">{{ $offer->customer->company->name }} •
                                {{ Str::ucfirst($offer->status) }}
                            </p>
                        </div>
                        <div class="text-end">
                            <p>
                                <span class="font-semibold">{{ $offer->getFormattedTotal() }}</span> /
                                <span class="text-xs opacity-70">{{ $offer->getTotalHours() }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <div class="md:col-span-4">
        <h3>{{ __('Quick actions') }}</h3>
        <div class="flex flex-col gap-2 mt-3">
            <a class="btn btn-outline w-full" href="{{ route('admin.projects.edit', $project->id) }}">
                {{ __('Edit project details') }}
            </a>
            <button class="btn btn-outline w-full" type="button" data-modal-target="confirm-project-complete">
                {{ __('Mark as complete') }}
            </button>
            <button class="btn btn-outline w-full" type="button" data-modal-target="confirm-project-hold">
                {{ __('Put on Hold') }}
            </button>
            <button class="btn btn-neutral w-full" type="button" data-modal-target="confirm-project-delete">
                {{ __('Archive project') }}
            </button>
        </div>
    </div>
    @include('admin.project.modals.project-complete')
    @include('admin.project.modals.project-on-hold')
    @include('admin.project.modals.delete-project')
</div>