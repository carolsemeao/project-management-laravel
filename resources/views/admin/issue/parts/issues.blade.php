@php
    $projects = \App\Models\Project::all();
    $statuses = \App\Models\Status::all();
    $priorities = \App\Models\Priority::all();
@endphp
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
                            data-original-status="{{ $issue->status_id }}" name="status_id">
                            @foreach ($statuses as $status)
                                <option value="{{ $status->id }}" {{ $issue->status_id == $status->id ? 'selected' : '' }}>
                                    {{ Str::title(str_replace('_', ' ', $status->name)) }}
                                </option>
                            @endforeach
                        </select>
                    @else
                        <x-badge :label="Str::title(str_replace('_', ' ', $issue->status->name))" />
                    @endif
                </td>
                <td>
                    <x-priority_badge :priority="$issue->priority->name" />
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