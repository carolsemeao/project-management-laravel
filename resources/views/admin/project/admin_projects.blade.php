@extends('admin.admin_master')
@section('title', 'Projects')
@section('page_title', 'Projects')
@section('page_subtitle', 'Manage your projects and track progress')
@section('maincontent')
    <div class="row row-eq-height">
        @foreach($projects as $project)
            <div class="col-4">
                <a href="{{ route('admin.projects.show', $project->id) }}" class="card text-decoration-none h-100">
                    <div class="card-body d-flex flex-column">
                        <p class="mb-0 mt-1 d-flex align-items-center">
                            <span class="me-2 rounded-circle d-inline-block"
                                style="width: 10px; height: 10px; background-color: {{ $project->color }};"></span>
                            <span>{{ $project->name }}</span>
                        </p>
                        <p class="text-muted small">{{ $project->description }}</p>

                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <select class="form-select form-select-sm status-select" data-project-id="{{ $project->id }}"
                                data-original-status="{{ $project->status }}" name="project_status" style="width: 200px;">
                                <option value="planning" {{ $project->status === 'planning' ? 'selected' : '' }}>Planning
                                </option>
                                <option value="in_progress" {{ $project->status === 'in_progress' ? 'selected' : '' }}>In
                                    Progress</option>
                                <option value="feedback" {{ $project->status === 'feedback' ? 'selected' : '' }}>Feedback
                                </option>
                                <option value="closed" {{ $project->status === 'closed' ? 'selected' : '' }}>Closed
                                </option>
                                <option value="active" {{ $project->status === 'active' ? 'selected' : '' }}>Active
                                </option>
                            </select>
                            <x-badge classes="fw-bold"
                                label="{{__(':openIssue / :totalIssues Issues', ['openIssue' => $project->getIssuesByStatus('open'), 'totalIssues' => $project->issues()->count()])}}" />
                        </div>

                        <div class="mt-auto mb-3">
                            <strong class="text-muted small">{{ __('Progress') }}</strong>
                            <div class="mt-1">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <small class="text-muted">{{ $project->getProgressPercentage() }}% complete</small>
                                    <small class="text-muted">{{ $project->issues()->count() }} issues</small>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-dark" role="progressbar"
                                        style="width: {{ $project->getProgressPercentage() }}%"></div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between">
                            <p class="mb-0 mt-1 d-flex align-items-center text-muted small">
                                <i data-feather="users" class="me-1" style="width: 16px; height: 16px;"></i>
                                {{ $project->getIssuesByStatus('open') }} open
                            </p>
                            <p class="mb-0 mt-1 d-flex align-items-center text-muted small">
                                <i data-feather="calendar" class="me-1" style="width: 16px; height: 16px;"></i>
                                {{ $project->due_date ? $project->due_date->format('d/m/Y') : __('Not set') }}
                                @if($project->isOverdue())
                                    <x-badge :label="__('Overdue')" textColor="text-danger" classes="ms-1 small" />
                                @elseif($project->isDueSoon())
                                    <x-badge :label="__('Due Soon')" textColor="text-warning" classes="ms-1 small" />
                                @endif
                            </p>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endsection