@extends('admin.admin_master')
@section('title', 'Admin Dashboard')

@php
    $id = Auth::user()->id;
    $profileData = App\Models\User::find($id);
@endphp
@section('page_title', __('Welcome back, :Name', ['name' => $profileData->name ?? 'User']))
@section('page_subtitle', $dateMessage)
@section('maincontent')

    <div class="row gy-4 gx-4">
        <div class="col-6 col-md-4 col-lg-3">
            @include('components.card', [
                'title' => __('Total Projects'),
                'icon' => 'target',
                'text' => $totalProjects,
                'subtitle' => __(':numberOfActiveProjects active project', ['numberOfActiveProjects' => $activeProjects])
            ])
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            @include('components.card', [
                'title' => __('Open Issues'),
                'icon' => 'alert-circle',
                'text' => $openIssues,
                'subtitle' => __('of :totalIssues total issues', ['totalIssues' => $totalIssues])
            ])
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            @include('components.card', [
                'title' => __('Time Logged'),
                'icon' => 'clock',
                'text' => $totalLoggedTime,
                'subtitle' => __('across all projects')
            ])
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            @include('components.card', [
                'title' => __('Completed'),
                'icon' => 'trending-up',
                'text' => $completedProjectsInMonth,
                'subtitle' => __('Projects this month')
            ])
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="card h-100">
                    <div class="card-body">
                    <h5 class="card-title mb-3">{{ __('Project Status Distribution') }}</h5>
                    <div class="chart-container d-flex justify-content-center" style="height: 300px;">
                        <canvas id="projectStatusChart" width="300" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title mb-3">{{ __('Issue Status Overview') }}</h5>
                    <div class="chart-container d-flex justify-content-center" style="height: 300px;">
                        <canvas id="issueStatusBarChart" width="300" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

@endsection