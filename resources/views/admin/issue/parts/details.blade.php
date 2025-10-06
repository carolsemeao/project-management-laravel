<div class="card mb-6">
    <div class="card-body">
        <h2 class="card-title mb-4">{{ __('Issue Details') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-3 gap-y-5">
            <div>
                <h3>{{ __('Status') }}</h3>
                <p class="mb-0 mt-1">
                    <x-badge :label="$issue->getFormattedStatus()" />
                </p>
            </div>
            <div>
                <h3>{{ __('Priority') }}</h3>
                <p class="mb-0 mt-1">
                    <x-priority_badge :priority="$issue->priority->name" iconsize="sm" classes="badge-sm" />
                </p>
            </div>
            <div>
                <h3>{{ __('Assignee') }}</h3>
                <p class="mb-0 mt-1 @if(!$issue->assignedUser) opacity-60 @endif">
                    <span class="icon icon-sm icon-user me-1"></span>
                    @if($issue->assignedUser)
                        {{ $issue->assignedUser->name }}
                    @else
                        {{ __('Not assigned') }}
                    @endif
                </p>
            </div>
            <div>
                <h3>{{ __('Due Date') }}</h3>
                <p class="mb-0 mt-1">
                    <span class="icon icon-sm icon-calendar me-1"></span>
                    {{ $issue->issue_due_date ? $issue->issue_due_date->format('d.m.Y') : __('Not set') }}
                    @if($issue->isDueSoon())
                        <x-badge :label="__('Due Soon')" classes="ms-1 badge-warning badge-dash"
                            darkClass="dark:badge-warning" />
                    @endif
                    @if($issue->isOverdue())
                        <x-badge :label="__('Overdue')" classes="ms-1 badge-error badge-dash"
                            darkClass="dark:badge-error" />
                    @endif
                </p>
            </div>
            <div>
                <h3>{{ __('Created') }}</h3>
                <p class="mb-0 mt-1">
                    <span class="icon icon-sm icon-calendar me-1"></span>
                    {{ $issue->created_at->format('d.m.Y') }}
                    @if($issue->createdByUser)
                        {{ __('by :createdByUser', ['createdByUser' => $issue->createdByUser->name]) }}
                    @endif
                </p>
            </div>
            <div>
                <h3>{{ __('Project') }}</h3>
                <p class="mb-0 mt-1 @if(!$issue->project) opacity-60 @endif">
                    {{ $issue->project ? $issue->project->name : __('No project assigned') }}
                </p>
            </div>
        </div>
        @if($issue->issue_description)
            <div class="divider my-5"></div>
            <div>
                <h3>{{ __('Description') }}</h3>
                <p class="mt-2 mb-0">{{ $issue->issue_description }}</p>
            </div>
        @endif
    </div>
</div>