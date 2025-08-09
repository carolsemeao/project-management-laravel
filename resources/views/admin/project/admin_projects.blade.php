@extends('admin.admin_master')
@section('title', 'Projects')
@section('page_title', 'Projects')
@section('page_subtitle', 'Manage your projects and track progress')
@section('header_actions')
    <x-button-primary btnType="dark" classes="d-flex align-items-center justify-content-center" isLink=true
        href="{{ route('admin.projects.create') }}">
        <span class="icon icon-sm icon-plus me-2"></span>
        {{ __('New Project') }}
    </x-button-primary>
@endsection
@section('maincontent')
    <div class="row row-eq-height">
        @if($projects->count() > 0)
            @foreach($projects as $project)
                <div class="col-4">
                    <a href="{{ route('admin.projects.show', $project->id) }}" class="card text-decoration-none h-100">
                        <div class="card-body d-flex flex-column">
                            <p class="mb-0 mt-1 d-flex align-items-center">
                                <span class="me-2 rounded-circle d-inline-block"
                                    style="width: 10px; height: 10px; background-color: {{ $project->color }};"></span>
                                <span>{{ $project->name }}</span>
                            </p>
                            <p class="text-muted small">{{ Str::limit($project->description, 60, '...', true) }}</p>

                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <x-badge :label="$project->getFormattedStatusName()" classes="fw-bold" />
                                <x-badge classes="fw-bold"
                                    label="{{__(':completedIssues / :totalIssues Issues', ['completedIssues' => $project->getIssuesByStatus(6), 'totalIssues' => $project->issues()->count()])}}" />
                            </div>

                            <div class="mt-auto mb-3">
                                <strong class="text-muted small">{{ __('Progress') }}</strong>
                                <div class="mt-1">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <small class="text-muted">{{ $project->getProgressPercentage() }}% complete</small>
                                    </div>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-dark" role="progressbar"
                                            style="width: {{ $project->getProgressPercentage() }}%"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between">
                                <p class="mb-0 mt-1 d-flex align-items-center text-muted small">
                                    <span class="icon icon-sm icon-users me-1"></span>
                                    {{ $project->getOpenIssuesCount() }} open
                                </p>
                                <p class="mb-0 mt-1 d-flex align-items-center text-muted small">
                                    <span class="icon icon-sm icon-calendar me-1"></span>
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
        @else
            <p class="small text-muted">{{ __('No projects found') }}</p>
        @endif
    </div>
@endsection