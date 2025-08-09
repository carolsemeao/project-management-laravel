@php
    $projects = \App\Models\Project::all();
    $statuses = \App\Models\Status::all();
    $priorities = \App\Models\Priority::all();
@endphp
<table class="table table-hover">
    <thead>
        <tr>
            <th>{{ __('ID') }}</th>
            <th>{{ __('Issue') }}</th>
            @if((!isset($hideProjectColumn) || !$hideProjectColumn))
                <th>{{ __('Project') }}</th>
            @endif
            <th>{{ __('Status') }}</th>
            <th>{{ __('Priority') }}</th>
            <th>{{ __('Assignee') }}</th>
            <th>{{ __('Due Date') }}</th>
            @if((!isset($hideProjectColumn) || !$hideProjectColumn))
                <th>{{ __('Time logged') }}</th>
            @endif
            <th class="text-end">{{ __('Edit') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($issues as $issue)
            <tr data-project-id="{{ $issue->project_id ?? '' }}">
                <td>
                    <strong>
                        <a href="{{ route('admin.issues.show', $issue->id) }}" class="text-decoration-none">
                            #{{ $issue->id }}
                        </a>
                    </strong>
                </td>
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
                @if((!isset($hideProjectColumn) || !$hideProjectColumn))
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
                    <x-badge :label="$issue->getFormattedStatus()" />
                </td>
                <td>
                    <x-priority_badge :priority="$issue->priority->name" />
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        @if($issue->assignedUser)
                            <div>
                                <span class="icon icon-xs icon-user me-1"></span>
                                {{ $issue->assignedUser->name }}
                            </div>
                        @elseif($issue->issue_assigned_to)
                            <x-badge :label="$issue->issue_assigned_to" textColor="text-muted" classes="small" />
                        @else
                            <span class="text-muted small">{{ __('Unassigned') }}</span>
                        @endif
                    </div>
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <span class="icon icon-xs icon-calendar me-1"></span>
                        {{ $issue->issue_due_date ? $issue->issue_due_date->format('d/m/Y') : 'Not set' }}
                    </div>
                </td>
                @if((!isset($hideProjectColumn) || !$hideProjectColumn))
                    <td>
                        <div class="d-flex align-items-center">
                            <span class="icon icon-xs icon-clock me-1"></span>
                            {{ $issue->getFormattedLoggedTimeAttribute() ?? '0h' }} / <span class="text-muted">
                                {{ $issue->getFormattedEstimatedTimeAttribute() ?? '0h' }}</span>
                        </div>
                    </td>
                @endif

                <td class="text-end">
                    <a href="{{ route('admin.issues.edit', $issue->id) }}" class="text-decoration-none">
                        <span class="icon icon-sm icon-edit" aria-label="Edit"></span>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>