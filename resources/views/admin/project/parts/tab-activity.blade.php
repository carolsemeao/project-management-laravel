<div class="card mt-3">
    <div class="card-body">
        <h2 class="card-title">Recent Activity</h2>
        <small class="text-muted">
            {{ __('Latest time entries for this project') }}
        </small>
        <div class="mt-4">
            @foreach ($project->timeEntries as $timeEntry)
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i data-feather="clock" class="me-2" style="width: 16px; height: 16px;"></i>
                                <div>
                                    <h5 class="card-title">
                                        <a href="{{ route('admin.issues.show', $timeEntry->issue->id) }}"
                                            class="text-decoration-none">{{ $timeEntry->description }}</a>
                                    </h5>
                                    <small class="text-muted">{{ $timeEntry->issue->issue_title }} •
                                        {{ $timeEntry->work_date->format('d/m/Y') }}</small>
                                </div>
                            </div>
                            <x-badge :label="$timeEntry->getFormattedTimeAttribute()" textColor="text-dark"
                                classes="ms-1 small" />
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>