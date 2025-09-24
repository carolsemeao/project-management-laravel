@extends('admin.admin_master')
@section('title', 'Admin Dashboard')

@php
    $id = Auth::user()->id;
    $profileData = App\Models\User::find($id);
@endphp
@section('page_title', __('Welcome back, :Name', ['name' => $profileData->name ?? 'User']))
@section('page_subtitle', $dateMessage)
@section('maincontent')

    <div class="card-grid card-grid--sm">
        @include('components.card', [
            'title' => __('Total Projects'),
            'icon' => 'target',
            'text' => $totalProjects,
         'subtitle' => __(':numberOfActiveProjects active project', ['numberOfActiveProjects' => $activeProjects])
        ])
        @include('components.card', [
            'title' => __('Open Issues'),
            'icon' => 'alert-circle',
            'text' => $openIssues,
            'subtitle' => __('of :totalIssues total issues', ['totalIssues' => $totalIssues])
        ])
        @include('components.card', [
            'title' => __('Time Logged'),
            'icon' => 'clock',
            'text' => $totalLoggedTime,
            'subtitle' => __('across all projects')
        ])
        @include('components.card', [
            'title' => __('Completed'),
            'icon' => 'trending-up',
            'text' => $completedProjectsInMonth,
            'subtitle' => __('Projects this month')
        ])
    </div>

    <div class="card-grid card-grid--lg">
        <div class="card">
                <div class="card-body">
                <h2 class="card-title">{{ __('Project Status Distribution') }}</h2>
                <div class="chart-container">
                    <canvas id="projectStatusChart" width="300" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">{{ __('Issue Status Overview') }}</h2>
                <div class="chart-container">
                    <canvas id="issueStatusBarChart" width="300" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="card-grid card-grid--lg">
        <div class="card">
            <div class="card-body">
                <div class="card-header-with-action">
                    <div>
                        <h2 class="card-title">{{ __('Issues') }}</h2>
                        <p class="card-subtitle">{{ __('Open issues across all projects') }}</p>
                    </div>
                    <a href="{{ route('admin.issues') }}" class="button button--link">
                        {{ __('View All') }}
                    </a>
                </div>
                @include('admin.issue.parts.issues-teaser')
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="card-header-with-action">
                    <div>
                        <h2 class="card-title">{{ __('Active Projects') }}</h2>
                        <p class="card-subtitle">{{ __('Current projects in progress') }}</p>
                    </div>
                    <a href="{{ route('admin.issues') }}" class="btn btn-link text-decoration-none d-flex align-items-center text-dark small p-0">
                        {{ __('View All') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Project Status Chart
            const projectStatusCtx = document.getElementById('projectStatusChart');
            if (projectStatusCtx) {
                const projectStatusChart = new Chart(projectStatusCtx, @json($projectStatusChart));
                
                // Reset animation delay after initial animation completes
                setTimeout(() => {
                    projectStatusChart.options.animation.delay = undefined;
                }, 1000); // Wait for initial animation + delay to complete
            }

            // Issue Status Bar Chart
            const issueStatusCtx = document.getElementById('issueStatusBarChart');
            if (issueStatusCtx) {
                const issueStatusChart = new Chart(issueStatusCtx, @json($issueStatusBarChart));
                
                // Reset animation delay after initial animation completes
                setTimeout(() => {
                    issueStatusChart.options.animation.delay = undefined;
                }, 1000); // Wait for initial animation + delay to complete
            }
        });
    </script>
@endpush