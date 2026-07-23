<h2 class="card-title">Recent Activity</h2>
<p class="text-sm opacity-60 mb-4">
    {{ __('Latest time entries for this project') }}
</p>
@if($project->timeEntries->count() > 0)
    @foreach ($project->timeEntries as $timeEntry)
        <div class="card mb-2 hover:bg-base-200 transition-colors">
            <div class="card-body relative">
                <div class="flex justify-between items-center gap-4">
                    <div class="flex align-items-center mr-auto">
                        <span class="icon icon-sm icon-clock me-2"></span>
                        <div>
                            <h5 class="card-title">
                                {{ $timeEntry->description }}
                            </h5>
                            <p class="text-xs opacity-70">{{ $timeEntry->issue->issue_title }} •
                                {{ $timeEntry->work_date->format('d.m.Y') }}</p>
                        </div>
                    </div>
                    <x-badge :label="$timeEntry->getFormattedTimeAttribute()" textColor="text-dark" classes="ms-1 small" />
                    <a href="{{ route('admin.issues.show', $timeEntry->issue->id) }}"
                        class="btn btn-sm before:absolute before:inset-0">
                        {{ __('View') }}
                    </a>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="empty">
        <span class="icon icon-lg icon-activity mb-2 block"></span>
        <p class="text-sm">{{ __('No recent activity yet') }}</p>
        <p class="text-xs mt-1">{{ __('Start logging time to see all activity here') }}</p>
    </div>
@endif