<div class="card mb-4">
    <div class="card-body">
        <h2 class="card-title h5 mb-4">{{ __('Issue Details') }}</h2>
        <div class="row g-3">
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-muted small">{{ __('Project') }}</strong>
                    <p class="mb-0 mt-1 d-flex align-items-center">
                        @if($issue->project)
                            <span class="me-2 rounded-circle d-inline-block"
                                style="width: 10px; height: 10px; background-color: {{ $issue->project->color }};"></span>
                            <span>{{ $issue->project->name }}</span>
                        @else
                            <span class="text-muted">{{ __('No project assigned') }}</span>
                        @endif
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-muted small">{{ __('Priority') }}</strong>
                    <p class="mb-0 mt-1">
                        <x-priority_badge :priority="$issue->priority->name" />
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-muted small">{{ __('Assignee') }}</strong>
                    <p class="mb-0 mt-1">
                        <span class="icon icon-sm icon-user me-1"></span>
                        @if($issue->assignedUser)
                            {{ $issue->assignedUser->name }}
                            <small class="text-muted">({{ $issue->assignedUser->email }})</small>
                        @elseif($issue->issue_assigned_to)
                            {{ $issue->issue_assigned_to }} <small class="text-muted">(legacy)</small>
                        @else
                            <span class="text-muted">{{ __('Not assigned') }}</span>
                        @endif
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-muted small">{{ __('Due Date') }}</strong>
                    <p class="mb-0 mt-1">
                        <span class="icon icon-sm icon-calendar me-1"></span>
                        {{ $issue->issue_due_date ? $issue->issue_due_date->format('d/m/Y') : __('Not set') }}
                        @if($issue->issue_due_date && $issue->issue_due_date->isPast())
                            <x-badge :label="__('Due Soon')" textColor="text-warning" classes="ms-1" />
                        @endif
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-muted small">{{ __('Created') }}</strong>
                    <p class="mb-0 mt-1">
                        <span class="icon icon-sm icon-calendar me-1"></span>
                        {{ $issue->created_at->format('d/m/Y') }}
                        @if($issue->createdByUser)
                            {{ __('by :createdByUser', ['createdByUser' => $issue->createdByUser->name]) }}
                        @endif
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-1">
                    <strong class="text-muted small">{{ __('Status') }}</strong>
                    <p class="mb-0 mt-1">
                        <x-badge :label="$issue->getFormattedStatus()" />
                    </p>
                </div>
            </div>
        </div>

        @if($issue->issue_description)
            <hr class="my-4">
            <div>
                <strong class="text-muted small">{{ __('Description') }}</strong>
                <p class="mt-2 mb-0">{{ $issue->issue_description }}</p>
            </div>
        @endif
    </div>
</div>