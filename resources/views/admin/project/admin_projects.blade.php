@extends('admin.admin_master')
@section('title', 'Projects')
@section('page_title', 'Projects')
@section('page_subtitle', 'Manage your projects and track progress')
@section('header_actions')
    <a class="btn btn-neutral" href="{{ route('admin.projects.create') }}">
        <span class="icon icon-sm icon-plus me-2"></span>
        {{ __('New Project') }}
    </a>
@endsection
@section('maincontent')
    @if($projects->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($projects as $project)
                <a href="{{ route('admin.projects.show', $project->id) }}" class="card text-decoration-none h-full">
                    <div class="card-body">
                        <div class="flex items-center gap-2 mb-2">
                            <x-badge :label="$project->getFormattedStatusName()" classes="fw-bold" />
                            @if($project->isOverdue())
                                <x-badge :label="__('Overdue')" classes="badge-error" darkClass="dark:badge-error" />
                            @elseif($project->isDueSoon())
                                <x-badge :label="__('Due Soon')" classes="badge-warning" darkClass="dark:badge-warning" />
                            @endif
                        </div>

                        <h2 class="flex items-center gap-2">
                            <span class="status status-lg" style="background-color: {{ $project->color }}"></span>
                            <span>{{ $project->name }}</span>
                        </h2>
                        <p class="text-muted small">
                            {{ Str::limit($project->description, 60, '...', true) }}
                        </p>

                        <h3 class="mt-3">{{ __('Progress') }}</h3>
                        <div class="mb-4">
                            <span class="text-xs mb-1 opacity-70">
                                {{ __(':timePercentage % complete', ['timePercentage' => $project->getProgressPercentage()]) }}
                            </span>
                            <progress class="progress" value="{{ $project->getProgressPercentage() }}" max="100"></progress>
                        </div>

                        <div class="flex items-center justify-between">
                            <p class="flex items-center opacity-70">
                                <span class="icon icon-sm icon-users me-1"></span>
                                {{__(':completedIssues / :totalIssues Issues', ['completedIssues' => $project->getIssuesByStatus(6), 'totalIssues' => $project->issues()->count()])}}
                            </p>
                            <p class="flex items-center opacity-70 grow-0">
                                <span class="icon icon-sm icon-calendar me-1"></span>
                                {{ $project->due_date ? $project->due_date->format('d.m.Y') : __('Not set') }}
                            </p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="empty">
            <span class="icon icon-lg icon-folder mb-2 block"></span>
            <p class="text-sm">{{ __('No projects found') }}</p>
            <p class="text-xs mt-1">{{ __('Start creating projects to see them here') }}</p>
        </div>
    @endif
@endsection