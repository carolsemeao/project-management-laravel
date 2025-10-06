<div class="card mt-6">
    <div class="card-body">
        <div class="flex justify-between items-center mb-3 flex-wrap">
            <h2 class="card-title mb-0">{{ __('Project Information') }}</h2>
            @if($issue->project)
                <a href="{{ route('admin.projects.show', $issue->project->id) }}" class="btn btn-ghost">
                    {{ __('More Details') }}
                    <span class="icon icon-sm icon-arrow-right me-2"></span>
                </a>
            @endif
        </div>

        @if($issue->project)
            <h3>{{ __('Project Name') }}</h3>
            <p class="mb-3 flex items-center">
                <span class="me-2 rounded-full inline-block w-2.5 h-2.5"
                    style="background-color: {{ $issue->project->color }};"></span>
                {{ $issue->project->name }}
            </p>

            <h3>{{ __('Status') }}</h3>
            <x-badge :label="$issue->project->getFormattedStatusName()" classes="mb-3" />

            <h3>{{ __('Priority') }}</h3>
            <x-priority_badge :priority="$issue->project->priority->name" classes="badge-sm mb-3" />

            @if($issue->project->description)
                <h3>{{ __('Description') }}</h3>
                <p class="mb-3 opacity-70">{{ $issue->project->description }}</p>
            @endif

            <h3>{{ __('Progress') }}</h3>
            <div class="mb-3">
                <span class="text-xs mb-1 opacity-70">
                    {{ __(':timePercentage % complete / :issuesCount issues', ['timePercentage' => $issue->project->getProgressPercentage(), 'issuesCount' => $issue->project->issues()->count()]) }}
                </span>
                <progress class="progress" value="{{ $issue->project->getProgressPercentage() }}" max="100"></progress>
            </div>

            @if($issue->project->budget)
                <h3>{{ __('Budget') }}</h3>
                <p class="mb-3">
                    <span class="icon icon-xs icon-dollar-sign me-1"></span>
                    {{ number_format($issue->project->budget, 2) }}
                </p>
            @endif

            <h3>{{ __('Project Due Date') }}</h3>
            <p class="mb-0">
                <span class="icon icon-sm icon-calendar me-1"></span>
                {{ $issue->project->due_date ? $issue->project->due_date->format('d.m.Y') : __('Not set') }}
                @if($issue->project->isDueSoon())
                    <x-badge :label="__('Due Soon')" classes="ms-1 badge-warning badge-dash" darkClass="dark:badge-warning" />
                @endif
                @if($issue->project->isOverdue())
                    <x-badge :label="__('Overdue')" classes="ms-1 badge-error badge-dash" darkClass="dark:badge-error" />
                @endif
            </p>
        @else
            <div class="text-center text-muted py-5 opacity-70">
                <span class="icon icon-huge icon-folder me-2"></span>
                <p class="mb-0">{{ __('No project assigned to this issue') }}</p>
            </div>
        @endif
    </div>
</div>