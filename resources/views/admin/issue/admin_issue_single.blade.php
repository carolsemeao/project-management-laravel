@extends('admin.issue.admin_issue_single_template')
@section('title', 'Issue Details')
@section('page_title', $issue->issue_title)
@section('back_to_route', route('admin.issues'))
@section('back_to_text', __('Back to Issues'))
@section('header_actions')
    <div class="btn-group">
        <x-button-primary btnType="outline-dark" classes="d-flex align-items-center justify-content-center"
            furtherActions="data-bs-toggle=modal data-bs-target=#logTimeModal type=button">
            <span class="icon icon-sm icon-plus me-2"></span>
            {{ __('Log Time') }}
        </x-button-primary>
        <x-button-primary btnType="outline-dark" classes="d-flex align-items-center justify-content-center" isLink=true
            href="{{ route('admin.issues.edit', $issue->id) }}">
            <span class="icon icon-sm icon-edit me-2"></span>
            {{ __('Edit Issue') }}
        </x-button-primary>
    </div>
@endsection

@section('maincontent')
    <div class="row g-4">
        <!-- Left Column - Main Content -->
        <div class="col-lg-8">
            <!-- Issue Details Card -->
            @include('admin.issue.parts.details')

            <!-- Time Tracking Card -->
            @include('admin.issue.parts.time-tracking')

            <!-- Close Issue Modal -->
            @include('admin.issue.parts.close-issue-modal')

            <!-- Log Time Modal -->
            @include('admin.issue.parts.log-time-modal')

            <!-- Delete Issue Modal -->
            @include('admin.issue.parts.delete-issue-modal')
        </div>

        <!-- Right Column - Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Actions Card -->
            @include('admin.issue.parts.quick-actions')

            <!-- Project Information Card -->
            @include('admin.issue.parts.project-information')
        </div>
    </div>
@endsection