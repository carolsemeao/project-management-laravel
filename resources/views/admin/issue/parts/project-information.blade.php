<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title mb-0">{{ __('Project Information') }}</h5>
            <a href="{{ route('admin.projects.show', $issue->project->id) }}"
                class="text-decoration-none d-flex align-items-center">
                {{ __('More Details') }}
                <span class="icon icon-sm icon-arrow-right me-2"></span>
            </a>
        </div>

        @if($issue->project)
            <div class="mb-3">
                <strong class="text-muted small">{{ __('Project Name') }}</strong>
                <p class="mb-0 mt-1 d-flex align-items-center">
                    <span class="me-2 rounded-circle d-inline-block"
                        style="width: 10px; height: 10px; background-color: {{ $issue->project->color }};"></span>
                    <span>{{ $issue->project->name }}</span>
                </p>
            </div>

            <div class="mb-3">
                <strong class="text-muted small">{{ __('Status') }}</strong>
                <p class="mb-0 mt-1">
                    <x-badge :label="$issue->project->getFormattedStatusName()"
                        textColor="text-{{ $issue->project->status->name === 'active' ? 'success' : ($issue->project->status->name === 'planning' ? 'warning' : 'secondary') }}" />
                </p>
            </div>

            <div class="mb-3">
                <strong class="text-muted small">{{ __('Priority') }}</strong>
                <p class="mb-0 mt-1">
                    <x-badge :label="$issue->project->getFormattedPriorityName()"
                        textColor="text-{{ $issue->project->priority->name === 'urgent' ? 'danger' : ($issue->project->priority->name === 'high' ? 'warning' : 'secondary') }}" />
                </p>
            </div>

            @if($issue->project->description)
                <div class="mb-3">
                    <strong class="text-muted small">{{ __('Description') }}</strong>
                    <p class="mb-0 mt-1 small text-muted">{{ $issue->project->description }}</p>
                </div>
            @endif

            <div class="mb-3">
                <strong class="text-muted small">{{ __('Progress') }}</strong>
                <div class="mt-1">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <small class="text-muted">{{ $issue->project->getProgressPercentage() }}% complete</small>
                        <small class="text-muted">{{ $issue->project->issues()->count() }} issues</small>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-dark" role="progressbar"
                            style="width: {{ $issue->project->getProgressPercentage() }}%"></div>
                    </div>
                </div>
            </div>

            @if($issue->project->budget)
                <div class="mb-3">
                    <strong class="text-muted small">{{ __('Budget') }}</strong>
                    <p class="mb-0 mt-1">
                        <span class="icon icon-xs icon-dollar-sign me-1"></span>
                        {{ number_format($issue->project->budget, 2) }}
                    </p>
                </div>
            @endif

            <div class="mb-3">
                <strong class="text-muted small">{{ __('Project Due Date') }}</strong>
                <p class="mb-0 mt-1">
                    <span class="icon icon-xs icon-calendar me-1"></span>
                    {{ $issue->project->due_date ? $issue->project->due_date->format('d/m/Y') : __('Not set') }}
                    @if($issue->project->isOverdue())
                        <x-badge :label="__('Overdue')" textColor="text-danger" classes="ms-1 small" />
                    @elseif($issue->project->isDueSoon())
                        <x-badge :label="__('Due Soon')" textColor="text-warning" classes="ms-1 small" />
                    @endif
                </p>
            </div>

            @if($issue->project->teams->count() > 0)
                <div class="mb-0">
                    <strong class="text-muted small">{{ __('Project Teams') }}</strong>
                    <div class="mt-1">
                        @foreach($issue->project->teams as $team)
                            <x-badge :label="$team->name" classes="me-1 mb-1" />
                        @endforeach
                    </div>
                </div>
            @endif
        @else
            <div class="text-center text-muted py-3">
                <span class="icon icon-huge icon-folder me-2"></span>
                <p class="mb-0">{{ __('No project assigned to this issue') }}</p>
            </div>
        @endif
    </div>
</div>