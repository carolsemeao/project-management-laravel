@extends('admin.issue.admin_issue_single_template')
@section('title', 'Edit Issue #' . $issue->id)
@section('page_title', 'Edit Issue #' . $issue->id)

@section('maincontent')
    <div class="row g-4">
        <!-- Left Column - Main Content -->
        <div class="col-lg-8">
            <!-- Issue Details Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <h5 class="card-title">{{ __('Issue Details') }}</h5>
                        <a href="{{ route('admin.issues') }}" aria-label="{{ __('Edit Issue') }}"><i data-feather="settings"
                                style="width: 16px; height: 16px;"></i></a>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-1">
                                <strong class="text-muted small">{{ __('Project') }}</strong>
                                <p class="mb-0 mt-1 d-flex align-items-center">
                                    @if($issue->project)
                                        <span class="me-2 rounded-circle d-inline-block"
                                            style="width: 10px; height: 10px; background-color: {{ $issue->project->color }};"></span>
                                        <span>{{ $issue->project->name }}</span>
                                    @else
                                        <span class="text-muted">{{ __('No project assigned') }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <strong class="text-muted small">{{ __('Priority') }}</strong>
                                <p class="mb-0 mt-1">
                                    <x-priority_badge :priority="$issue->issue_priority" />
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <strong class="text-muted small">{{ __('Assignee') }}</strong>
                                <p class="mb-0 mt-1">
                                    <i data-feather="user" class="me-1" style="width: 16px; height: 16px;"></i>
                                    @if($issue->assignedUser)
                                        {{ $issue->assignedUser->name }}
                                        <small class="text-muted">({{ $issue->assignedUser->email }})</small>
                                    @elseif($issue->issue_assigned_to)
                                        {{ $issue->issue_assigned_to }} <small class="text-muted">(legacy)</small>
                                    @else
                                        <span class="text-muted">{{ __('Not assigned') }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <strong class="text-muted small">{{ __('Due Date') }}</strong>
                                <p class="mb-0 mt-1">
                                    <i data-feather="calendar" class="me-1" style="width: 16px; height: 16px;"></i>
                                    {{ $issue->issue_due_date ? $issue->issue_due_date->format('d/m/Y') : __('Not set') }}
                                    @if($issue->issue_due_date && $issue->issue_due_date->isPast())
                                        <x-badge :label="__('Due Soon')" textColor="text-warning" classes="ms-1" />
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <strong class="text-muted small">{{ __('Created') }}</strong>
                                <p class="mb-0 mt-1">
                                    <i data-feather="calendar" class="me-1" style="width: 16px; height: 16px;"></i>
                                    {{ $issue->created_at->format('d/m/Y') }}
                                    @if($issue->createdByUser)
                                        {{ __('by :createdByUser', ['createdByUser' => $issue->createdByUser->name]) }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <strong class="text-muted small">{{ __('Status') }}</strong>
                                <p class="mb-0 mt-1">
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
                                </p>
                            </div>
                        </div>
                    </div>

                    @if($issue->issue_description)
                        <hr class="my-4">
                        <div>
                            <strong class="text-muted small">{{ __('Description') }}</strong>
                            <p class="mt-2 mb-0">{{ $issue->issue_description }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column - Sidebar -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Current Status') }}</h5>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">Validation</h5>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Issue History') }}</h5>
                </div>
            </div>
        </div>
    </div>
@endsection