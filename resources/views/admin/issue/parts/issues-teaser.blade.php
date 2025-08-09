<div class="mt-4">
    @foreach ($userIssues as $issue)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $issue->issue_title }}</h5>
                <p class="card-text text-muted">{{ $issue->issue_description }}</p>

                <div class="text-muted small">
                    <span
                        class="d-block mb-1 @if ($issue->issue_due_date && $issue->issue_due_date->isPast()) text-danger @elseif($issue->issue_due_date && $issue->issue_due_date->isToday()) text-warning @endif">
                        <span class="icon icon-xs icon-calendar me-1"></span>
                        {{$issue->issue_due_date ? $issue->issue_due_date->format('d/m/Y') : __('No due date')}}
                    </span>
                    <x-badge :label="$issue->getFormattedStatus()" />
                </div>

                <div class="d-flex align-items-center gap-1">
                    <x-badge :label="$issue->project->name" />
                    <x-priority_badge :priority="$issue->priority->name" />
                </div>
            </div>
        </div>
    @endforeach
</div>