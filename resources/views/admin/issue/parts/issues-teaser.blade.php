<div class="mt-4">
    <div class="status-list">
        <div>
            <span class="status-circle status-circle--overdue"></span>
            {{ __('Overdue') }}
        </div>
        <div>
            <span class="status-circle status-circle--due-soon"></span>
            {{ __('Due soon') }}
        </div>
    </div>
    
    @foreach ($userIssues as $issue)
        <a href="{{ route('admin.issues.show', $issue->id) }}"
            class="issue-card @if ($issue->isOverdue())status status--overdue @elseif($issue->isDueSoon())status status--due-soon @endif">
            <div class="issue-card__body">
                <span
                    class="issue-card__body-date @if ($issue->isOverdue())issue-card__body-date--overdue @elseif($issue->isDueSoon())issue-card__body-date--due-soon @endif">
                    <span class="icon icon-xs icon-calendar me-1"></span>
                    {{$issue->issue_due_date ? $issue->issue_due_date->format('d/m/Y') : __('No due date')}}
                </span>
                <h3 class="issue-card__body-title">{{ $issue->issue_title }}</h3>
                <p class="issue-card__body-description">{{ $issue->issue_description }}</p>
                <div class="issue-card__body-tags">
                    <x-badge :label="$issue->getFormattedStatus()" />
                    <x-badge :label="$issue->project->name" />
                    <x-priority_badge :priority="$issue->priority->name" />
                </div>
            </div>
        </a>
    @endforeach
</div>