@extends('admin.admin_master')
@section('title', 'Admin Dashboard')

@php
    $id = Auth::user()->id;
    $profileData = App\Models\User::find($id);
@endphp
@section('page_title', __('Welcome back, :Name', ['name' => $profileData->name ?? 'User']))
@section('page_subtitle', $dateMessage)
@section('maincontent')
    <div class="stats stats-vertical border border-base-200/50 lg:stats-horizontal w-full mt-5">
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

    <div class="card-grid card-grid--lg mt-5">
        <div class="card card-border border-base-200/50 bg-fuchsia-50 dark:bg-neutral/30">
            <div class="card-body">
                <h2 class="card-title">{{ __('Project Status Distribution') }}</h2>
                <div class="chart-container">
                    <canvas id="projectStatusChart" width="300" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="card card-border border-base-200/50 bg-fuchsia-50 dark:bg-neutral/30">
            <div class="card-body">
                <h2 class="card-title">{{ __('Issue Status Overview') }}</h2>
                <div class="chart-container">
                    <canvas id="issueStatusBarChart" width="300" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="card-grid card-grid--lg">
        <div class="card card-border border-base-200/50 bg-fuchsia-50 dark:bg-neutral/30">
            <div class="card-body">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h2 class="card-title">{{ __('Issues') }}</h2>
                        <p class="card-subtitle">{{ __('Open issues across all projects') }}</p>
                    </div>
                    <a href="{{ route('admin.issues') }}" class="btn btn-ghost">
                        {{ __('View All') }}
                        <span class="icon icon-sm icon-arrow-right"></span>
                    </a>
                </div>
                @include('admin.issue.parts.issues-teaser')
            </div>
        </div>
        <div class="card card-border border-base-200/50 bg-fuchsia-50 dark:bg-neutral/30">
            <div class="card-body">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h2 class="card-title">{{ __('Active Projects') }}</h2>
                        <p class="card-subtitle">{{ __('Current projects in progress') }}</p>
                    </div>
                    <a href="{{ route('admin.issues') }}" class="btn btn-ghost">
                        {{ __('View All') }}
                        <span class="icon icon-sm icon-arrow-right"></span>
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