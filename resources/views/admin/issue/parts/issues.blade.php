@php
    $showAssignee ??= false;
    $showProjectColumn = !isset($showProjectColumn) || $showProjectColumn;
@endphp
<div class="overflow-x-auto">
    <table class="table">
        <thead>
            <tr>
                <th class="w-15">{{ __('ID') }}</th>
                <th class="w-100">{{ __('Issue') }}</th>
                @if($showProjectColumn)
                    <th>{{ __('Project') }}</th>
                @endif
                <th>{{ __('Status') }}</th>
                <th>{{ __('Priority') }}</th>
                @if(isset($showAssignee) && $showAssignee)
                    <th>{{ __('Assignee') }}</th>
                @endif
                <th>{{ __('Due Date') }}</th>
                @if($showProjectColumn)
                    <th>{{ __('Time logged') }}</th>
                @endif
                <th class="text-right">{{ __('Edit') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($issues as $issue)
                <tr data-project-id="{{ $issue->project_id ?? '' }}" class="hover:bg-base-200/80">
                    <td>
                        <a href="{{ route('admin.issues.show', $issue->id) }}" class="text-decoration-none font-medium">
                            #{{ $issue->id }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('admin.issues.show', $issue->id) }}" class="text-decoration-none font-medium">
                            <p>{{ $issue->issue_title }}</p>
                        </a>
                    </td>
                    @if($showProjectColumn)
                        <td>
                            @if($issue->project)
                                <a href="{{ route('admin.projects.show', $issue->project->id) }}"
                                    class="text-decoration-none text-xs font-medium">
                                    {{ $issue->project->name }}
                                </a>
                            @else
                                <p class="text-xs opacity-60 font-medium">
                                    {{ __('No project assigned') }}
                                </p>
                            @endif
                        </td>
                    @endif
                    <td>
                        <span class="badge badge-xs badge-dash badge-primary text-nowrap">
                            {{ $issue->getFormattedStatus() }}
                        </span>
                    </td>
                    <td>
                        <x-priority_badge :priority="$issue->priority->name" classes="badge-xs text-nowrap" iconsize="xs" />
                    </td>
                    @if(isset($showAssignee) && $showAssignee)
                        <td>
                            <div class="flex items-center">
                                @if($issue->assignedUser)
                                    <div class="text-nowrap">
                                        <span class="icon icon-xs icon-user me-1"></span>
                                        {{ $issue->assignedUser->name }}
                                    </div>
                                @else
                                    <p class="text-xs opacity-60 font-medium">
                                        {{ __('Unassigned') }}
                                    </p>
                                @endif
                            </div>
                        </td>
                    @endif
                    <td>
                        <div class="flex items-baseline text-nowrap">
                            <span class="icon icon-xs icon-calendar me-1"></span>
                            @if($issue->issue_due_date)
                                {{ $issue->issue_due_date->format('d/m/Y') }}
                            @else
                                <span class="opacity-60">
                                    {{ __('Not set') }}
                                </span>
                            @endif
                        </div>
                    </td>
                    @if($showProjectColumn)
                        <td>
                            <div class="flex items-center text-nowrap">
                                <span class="icon icon-xs icon-clock me-1"></span>
                                {{ $issue->getFormattedLoggedTimeAttribute() ?? '0h' }} /
                                {{ $issue->getFormattedEstimatedTimeAttribute() ?? '0h' }}
                            </div>
                        </td>
                    @endif

                    <td class="text-right">
                        <a href="{{ route('admin.issues.edit', $issue->id) }}" class="text-decoration-none"
                            title="{{ __('Edit issue') }}">
                            <span class="icon icon-sm icon-edit" aria-label="{{ __('Edit') }}"></span>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>