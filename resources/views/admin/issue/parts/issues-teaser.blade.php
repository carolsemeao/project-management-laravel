<div>
    <div class="status-list mb-6">
        <div>
            <div aria-label="status" class="status status-xl bg-neutral dark:bg-secondary"></div>
            <span class="ms-1">{{ __('Overdue') }}</span>
        </div>
        <div>
            <div aria-label="status" class="status status-xl bg-base-200"></div>
            <span class="ms-1">{{ __('Due soon') }}</span>
        </div>
    </div>
    
    @foreach ($userIssues as $issue)
        <a href="{{ route('admin.issues.show', $issue->id) }}"
            class="card card-sm mb-4 @if ($issue->isOverdue())bg-neutral text-neutral-content dark:bg-secondary dark:text-secondary-content @elseif($issue->isDueSoon())bg-base-200 text-base-content @endif">
            <div class="card-body">
                <span
                    class="card-body__date @if ($issue->isOverdue())issue-card__body-date--overdue @elseif($issue->isDueSoon())issue-card__body-date--due-soon @endif">
                    <span class="icon icon-xs icon-calendar me-1"></span>
                    {{$issue->issue_due_date ? $issue->issue_due_date->format('d/m/Y') : __('No due date')}}
                </span>
                <h3 class="card-title">{{ $issue->issue_title }}</h3>
                <p>{{ $issue->issue_description }}</p>
                <div class="card-actions">
                    <span class="badge badge-sm badge-dash @if ($issue->isOverdue())badge-primary @elseif($issue->isDueSoon())badge-error @endif">
                        {{ $issue->getFormattedStatus() }}
                    </span>
                    <span class="badge badge-sm badge-dash @if ($issue->isOverdue())badge-primary @elseif($issue->isDueSoon())badge-error @endif"">
                        {{ $issue->project->name }}
                    </span>
                    <span class="badge badge-sm badge-dash @if ($issue->isOverdue())badge-primary @elseif($issue->isDueSoon())badge-error @endif"">
                        {{ Str::ucfirst(str_replace('_', ' ', $issue->priority->name)) }} Priority
                    </span>
                </div>
            </div>
        </a>
    @endforeach
</div>