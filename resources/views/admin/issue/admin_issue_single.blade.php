@extends('admin.issue.admin_issue_single_template')
@section('title', 'Issue Details')
@section('page_title', $issue->issue_title)
@section('back_to_route', route('admin.issues'))
@section('back_to_text', __('Back to Issues'))
@section('header_actions')
    <div class="join">
        <button class="btn btn-soft join-item" type="button" data-modal-target="confirm-log-time">
            <span class="icon icon-sm icon-plus me-2"></span>
            {{ __('Log Time') }}
        </button>
        <a href="{{ route('admin.issues.edit', $issue->id) }}" class="btn btn-soft join-item">
            <span class="icon icon-sm icon-edit me-2"></span>
            {{ __('Edit Issue') }}
        </a>
    </div>
@endsection

@section('maincontent')
    <div class="md:grid md:grid-cols-12 gap-4">
        <!-- Left Column - Main Content -->
        <div class="md:col-span-8">
            <!-- Issue Details Card -->
            @include('admin.issue.parts.details')

            <!-- Time Tracking Card -->
            @include('admin.issue.parts.time-tracking')

            <!-- Close Issue Modal -->
            @include('admin.issue.modals.close-issue-modal')

            <!-- Log Time Modal -->
            @include('admin.issue.modals.log-time-modal')

            <!-- Delete Issue Modal -->
            @include('admin.issue.modals.delete-issue-modal')
        </div>

        <!-- Right Column - Sidebar -->
        <div class="md:col-span-4">
            <!-- Quick Actions Card -->
            @include('admin.issue.parts.quick-actions')

            <!-- Project Information Card -->
            @include('admin.issue.parts.project-information')
        </div>
    </div>
@endsection