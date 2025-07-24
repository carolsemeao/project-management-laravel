<table class="table table-hover">
    <thead>
        <tr>
            <th>Issue</th>
            @if((!isset($hideProjectColumn) || !$hideProjectColumn) && !request()->routeIs('admin.projects.show'))
                <th>Project</th>
            @endif
            <th>Status</th>
            <th>Priority</th>
            <th>Assignee</th>
            <th>Due Date</th>
            @if((!isset($hideProjectColumn) || !$hideProjectColumn) && !request()->routeIs('admin.projects.show'))
                <th>Time logged</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($issues as $issue)
            <tr>
                <td>
                    <div>
                        <strong>
                            <a href="{{ route('admin.issues.show', $issue->id) }}" class="text-decoration-none">
                                {{ $issue->issue_title }}
                            </a>
                        </strong>
                        @if(isset($issue->issue_description))
                            <div class="text-muted small">{{ Str::limit($issue->issue_description, 60) }}</div>
                        @endif
                    </div>
                </td>
                @if((!isset($hideProjectColumn) || !$hideProjectColumn) && !request()->routeIs('admin.projects.show'))
                    <td>
                        <p class="mb-0 d-flex align-items-center">
                            @if($issue->project)
                                <span class="me-2 rounded-circle d-inline-block"
                                    style="width: 10px; height: 10px; background-color: {{ $issue->project->color }};"></span>
                                <span>{{ $issue->project->name }}</span>
                            @else
                                <span class="text-muted">{{ __('No project assigned') }}</span>
                            @endif
                        </p>
                    </td>
                @endif
                <td>
                    @if((!isset($hideProjectColumn) || !$hideProjectColumn) && !request()->routeIs('admin.projects.show'))
                        <select class="form-select form-select-sm status-select" data-issue-id="{{ $issue->id }}"
                            data-original-status="{{ $issue->issue_status }}" name="issue_status">
                            <option value="waiting_for_planning" {{ $issue->issue_status === 'waiting_for_planning' ? 'selected' : '' }}>Waiting for Planning</option>
                            <option value="planned" {{ $issue->issue_status === 'planned' ? 'selected' : '' }}>Planned
                            </option>
                            <option value="in_progress" {{ $issue->issue_status === 'in_progress' ? 'selected' : '' }}>In
                                Progress</option>
                            <option value="on_hold" {{ $issue->issue_status === 'on_hold' ? 'selected' : '' }}>On Hold
                            </option>
                            <option value="feedback" {{ $issue->issue_status === 'feedback' ? 'selected' : '' }}>Feedback
                            </option>
                            <option value="resolved" {{ $issue->issue_status === 'resolved' ? 'selected' : '' }}>Resolved
                            </option>
                            <option value="closed" {{ $issue->issue_status === 'closed' ? 'selected' : '' }}>Closed
                            </option>
                            <option value="rejected" {{ $issue->issue_status === 'rejected' ? 'selected' : '' }}>Rejected
                            </option>
                        </select>
                    @else
                        @php
                            $statusLabel = match ($issue->issue_status) {
                                'waiting_for_planning' => __('Waiting for Planning'),
                                'planned' => __('Planned'),
                                'in_progress' => __('In Progress'),
                                'feedback' => __('Feedback'),
                                'closed' => __('Closed'),
                                'rejected' => __('Rejected'),
                                'open' => __('Open'),
                                default => ucfirst(str_replace('_', ' ', $issue->issue_status))
                            };
                        @endphp
                        <x-badge :label="$statusLabel" />
                    @endif
                </td>
                <td>
                    <x-priority_badge :priority="$issue->issue_priority" />
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        @if($issue->assignedUser)
                            <div>
                                <i data-feather="user" class="me-1" style="width: 14px; height: 14px;"></i>
                                {{ $issue->assignedUser->name }}
                            </div>
                        @elseif($issue->issue_assigned_to)
                            <x-badge :label="$issue->issue_assigned_to" textColor="text-muted" classes="small" />
                        @else
                            <span class="text-muted small">Unassigned</span>
                        @endif
                    </div>
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <i data-feather="calendar" class="me-1" style="width: 14px; height: 14px;"></i>
                        {{ $issue->due_date ? $issue->due_date->format('d/m/Y') : 'Not set' }}
                    </div>
                </td>
                @if((!isset($hideProjectColumn) || !$hideProjectColumn) && !request()->routeIs('admin.projects.show'))
                    <td>
                        <div class="d-flex align-items-center">
                            <i data-feather="clock" class="me-1" style="width: 14px; height: 14px;"></i>
                            {{ $issue->getFormattedLoggedTimeAttribute() ?? '0h' }} / <span class="text-muted">
                                {{ $issue->getFormattedEstimatedTimeAttribute() ?? '0h' }}</span>
                        </div>
                    </td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>