<div class="cards">
    @foreach ($userIssues as $issue)
        <a href="{{ route('admin.issues.show', $issue->id) }}" class="cards-item group">
            <div class="card-body">
                <div class="flex justify-between items-start">
                    <div>
                        <span class="card-body__date">
                            <span class="icon icon-xs icon-calendar me-1"></span>
                            {{$issue->issue_due_date ? $issue->issue_due_date->format('d/m/Y') : __('No due date')}}
                        </span>
                        <h3 class="card-title my-1.5">{{ $issue->issue_title }}</h3>
                        <p>{{ $issue->issue_description }}</p>
                    </div>
                    @if($issue->isOverdue())
                        <span class="badge badge-sm badge-dash font-medium">
                            <span class="icon icon-xs icon-alert-triangle"></span>
                            {{ __('Overdue') }}
                        </span>
                    @elseif($issue->isDueSoon())
                        <span class="badge badge-sm badge-dash font-medium">
                            <span class="icon icon-xs icon-alert-circle"></span>
                            {{ __('Due soon') }}
                        </span>
                    @endif
                </div>

                <div class="card-actions mt-1">
                    @if($issue->status)
                        <span class="badge badge-sm badge-dash">
                            {{ $issue->getFormattedStatus() }}
                        </span>
                    @endif
                    @if($issue->project)
                        <span class="badge badge-sm badge-dash">
                            {{ $issue->project->name }}
                        </span>
                    @endif
                    @if($issue->priority)
                        <span class="badge badge-sm badge-dash">
                            {{ Str::ucfirst(str_replace('_', ' ', $issue->priority->name)) }} Priority
                        </span>
                    @endif
                    </span>
                </div>
            </div>
        </a>
    @endforeach
</div>