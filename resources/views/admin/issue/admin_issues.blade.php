@extends('admin.admin_master')
@section('title', 'Team Issues')
@section('page_title', 'Team Issues')
@section('page_subtitle', 'Track and manage project issues')
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

    <!-- Toast for feedback -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="statusToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body d-flex justify-content-between align-items-center">
                <span id="statusToastText"></span>
                <button type="button" class="btn-close text-white ms-2" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endsection