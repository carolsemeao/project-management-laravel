@extends('admin.admin_master')
@section('title', 'Issues')
@section('page_title', 'Issues')
@section('page_subtitle', 'Track and manage project issues')
@section('header_actions')
    <div class="d-flex align-items-center gap-2">
        <select class="form-select" id="project_id" name="project_id" onchange="filterIssues(event)">
            <option value="">{{ __('All Projects') }}</option>
            @foreach ($projects as $project)
                <option value="{{ $project->id }}">{{ $project->name }}</option>
            @endforeach
        </select>
        <x-button-primary btnType="dark" classes="d-flex align-items-center justify-content-center text-nowrap"
            isLink="true" href="{{ route('admin.issues.create') }}">
            <span class="icon icon-sm icon-plus me-2"></span>
            {{ __('New Issue') }}
        </x-button-primary>
    </div>
@endsection
@section('maincontent')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Issues</h5>
            <p class="card-text text-muted">{{ $issues->count() }} issues</p>
        </div>
        <div class="card-body">
            @include('admin.issue.parts.issues', ['issues' => $issues])
        </div>
    </div>
@endsection