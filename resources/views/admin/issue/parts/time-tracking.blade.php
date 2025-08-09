<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title mb-0">{{ __('Time Tracking') }}</h5>
        </div>

        @if($issue->estimated_time_minutes || $issue->getTotalLoggedTimeMinutes() > 0)
            <div class="mb-3">
                <div class="d-flex align-items-center mb-2">
                    <span class="icon icon-clock me-2"></span>
                    <div>
                        <strong id="logged-time-display">{{ $issue->formatted_logged_time ?: '0m' }}</strong>
                        @if($issue->estimated_time_minutes)
                            <span class="text-muted">of {{ $issue->formatted_estimated_time }} estimated</span>
                        @endif
                    </div>
                </div>

                @if($issue->estimated_time_minutes)
                    @php $timeStatus = $issue->getTimeTrackingStatus(); @endphp
                    <div class="mb-2">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <small class="text-muted">{{ $timeStatus['percentage'] }}% completed</small>
                        </div>
                        <div class="progress" style="height: 8px;" id="time-progress">
                            <div class="progress-bar bg-dark" role="progressbar"
                                style="width: {{ min($timeStatus['percentage'], 100) }}%"></div>
                        </div>
                    </div>
                @endif
            </div>
        @else
            <p class="text-muted mb-3">{{ __('No time tracking data yet') }}</p>
        @endif

        <hr class="my-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0">{{ __('Recent Time Entries') }}</h6>
        </div>

        <div id="time-entries-container">
            @if($issue->timeEntries()->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('User') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th>{{ __('Time') }}</th>
                            </tr>
                        </thead>
                        <tbody id="time-entries-table">
                            @foreach($issue->timeEntries()->with('user')->get() as $entry)
                                <tr>
                                    <td>
                                        <span class="icon icon-xs icon-calendar me-1"></span>
                                        {{ $entry->work_date->format('d/m/Y') }}
                                    </td>
                                    <td>{{ $entry->user->name }}</td>
                                    <td>{{ $entry->description ?: __('No description') }}</td>
                                    <td><x-badge :label="$entry->formatted_time" /></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center text-muted py-3">
                    <span class="icon icon-huge icon-clock me-2"></span>
                    <p class="mb-0 small">{{ __('No time entries yet') }}</p>
                </div>
            @endif
        </div>
    </div>
</div>