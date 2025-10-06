<div class="card">
    <div class="card-body">
        <h2 class="card-title mb-0">{{ __('Time Tracking') }}</h2>

        @if($issue->estimated_time_minutes || $issue->getTotalLoggedTimeMinutes() > 0)
            <div>
                <div class="flex items-center mb-3">
                    <span class="icon icon-clock me-2"></span>
                    <div>
                        <span class="font-semibold">{{ $issue->formatted_logged_time ?: '0m' }}</span>
                        @if($issue->estimated_time_minutes)
                            <span class="opacity-60">
                                {{ __('of :formattedEstimatedTime estimated', ['formattedEstimatedTime' => $issue->formatted_estimated_time]) }}
                            </span>
                        @endif
                    </div>
                </div>

                @if($issue->estimated_time_minutes)
                    @php $timeStatus = $issue->getTimeTrackingStatus(); @endphp
                    <div class="mb-2">
                        <span class="text-xs mb-1 opacity-70">
                            {{ __(':timePercentage % completed', ['timePercentage' => $timeStatus['percentage']]) }}
                        </span>
                        <progress class="progress" value="{{ $timeStatus['percentage'] }}" max="100"></progress>
                    </div>
                @endif
            </div>
        @else
            <p class="text-muted mb-3">{{ __('No estimated time set') }}</p>
        @endif

        <div class="divider my-3"></div>

        <h3 class="mb-2">{{ __('Recent Time Entries') }}</h3>

        @if($issue->timeEntries()->count() > 0)
            <div class="overflow-x-auto">
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
                                    {{ $entry->work_date->format('d.m.Y') }}
                                </td>
                                <td>{{ $entry->user->name }}</td>
                                <td>{{ $entry->description ?: __('No description') }}</td>
                                <td>{{ $entry->formatted_time }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center text-muted py-5 opacity-70">
                <span class="icon icon-huge icon-clock mb-2"></span>
                <p class="mb-0 text-sm">{{ __('No time entries yet') }}</p>
            </div>
        @endif
    </div>
</div>