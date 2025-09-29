<div>
    @foreach ($userIssues as $issue)
        <a href="{{ route('admin.issues.show', $issue->id) }}"
            class="card card-sm mb-4 group transition-all duration-200 border-1 border-dashed border-base-300/60 hover:border-base-content dark:border-base-content/10 bg-white/50 hover:bg-base-300/80 dark:hover:text-neutral-content dark:bg-base-200 dark:hover:bg-neutral dark:hover:bg-neutral dark:hover:text-neutral-content">
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
                    <span class="badge badge-sm badge-dash">
                        {{ $issue->getFormattedStatus() }}
                    </span>
                    <span class="badge badge-sm badge-dash">
                        {{ $issue->project->name }}
                    </span>
                    <span class="badge badge-sm badge-dash">
                        {{ Str::ucfirst(str_replace('_', ' ', $issue->priority->name)) }} Priority
                    </span>
                </div>
            </div>
        </a>
    @endforeach
</div>