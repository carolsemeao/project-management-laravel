@extends('admin.admin_master')
@section('title', __('Dashboard'))

@php
    $id = Auth::user()->id;
    $profileData = App\Models\User::find($id);
@endphp
@section('page_title', __('Welcome back, :Name', ['name' => $profileData->name ?? 'User']))
@section('page_subtitle', $dateMessage)
@section('maincontent')
    <div class="stats stats-vertical border-1 border-base-300/60 dark:border-base-content/10 border-dashed lg:stats-horizontal w-full">
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

    <div class="card-grid card-grid--lg my-6">
        <div class="card bg-base-200/20 dark:bg-neutral/30">
            <div class="card-body">
                <h2 class="card-title">{{ __('Project Status Distribution') }}</h2>
                <div class="chart-container">
                    <canvas id="projectStatusChart" width="300" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="card bg-base-200/20 dark:bg-neutral/30">
            <div class="card-body">
                <h2 class="card-title">{{ __('Issue Status Overview') }}</h2>
                <div class="chart-container">
                    <canvas id="issueStatusBarChart" width="300" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="card-grid card-grid--lg mt-6">
        <div class="card bg-base-200/20 dark:bg-neutral/30">
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
        <div class="card bg-base-200/20 dark:bg-neutral/30">
            <div class="card-body">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h2 class="card-title">{{ __('Recent Projects') }}</h2>
                        <p class="card-subtitle">{{ __('Recently updated active projects') }}</p>
                    </div>
                    <a href="{{ route('admin.projects') }}" class="btn btn-ghost">
                        {{ __('View All') }}
                        <span class="icon icon-sm icon-arrow-right"></span>
                    </a>
                </div>
                @include('admin.project.parts.projects-teaser')
            </div>
        </div>
    </div>
    <div class="card-container mt-6">
        <div class="card bg-base-200/20 dark:bg-neutral/30">
            <div class="card-body">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h2 class="card-title">{{ __('Recent Activity') }}</h2>
                        <p class="card-subtitle">{{ __('Your latest actions and updates') }}</p>
                    </div>
                </div>
                @include('admin.activity.parts.recent-activity')
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const resolveChartColors = chartData => {
            const computedStyle = getComputedStyle(document.documentElement);
            const resolvedData = JSON.parse(JSON.stringify(chartData)); // Deep clone needed
            
            const resolveColors = colors => colors.map(color => {
                if (color.startsWith('var(')) {
                    const varName = color.slice(4, -1);
                    return computedStyle.getPropertyValue(varName).trim() || '#6c757d';
                }
                return color;
            });
            
            // Handle different chart types
            resolvedData.data.datasets.forEach(dataset => {
                if (dataset.backgroundColor) {
                    dataset.backgroundColor = Array.isArray(dataset.backgroundColor) 
                        ? resolveColors(dataset.backgroundColor)
                        : resolveColors([dataset.backgroundColor]);
                }
                if (dataset.borderColor) {
                    dataset.borderColor = Array.isArray(dataset.borderColor)
                        ? resolveColors(dataset.borderColor) 
                        : resolveColors([dataset.borderColor]);
                }
            });
            
            return resolvedData;
        };
    
        // Project Status Chart
        const projectStatusCtx = document.getElementById('projectStatusChart');
        let projectChart;
        const originalProjectData = @json($projectStatusChart);
        
        if (projectStatusCtx) {
            projectChart = new Chart(projectStatusCtx, resolveChartColors(originalProjectData));
            setTimeout(() => projectChart.options.animation.delay = undefined, 1000);
        }
    
        // Issue Status Bar Chart
        const issueStatusCtx = document.getElementById('issueStatusBarChart');
        let issueChart;
        const originalIssueData = @json($issueStatusBarChart);
        
        if (issueStatusCtx) {
            issueChart = new Chart(issueStatusCtx, resolveChartColors(originalIssueData));
            setTimeout(() => issueChart.options.animation.delay = undefined, 1000);
        }
        
        const updateAllChartColors = () => {
            if (projectChart) {
                const resolvedData = resolveChartColors(originalProjectData);
                projectChart.data.datasets.forEach((dataset, index) => {
                    dataset.backgroundColor = resolvedData.data.datasets[index].backgroundColor;
                    dataset.borderColor = resolvedData.data.datasets[index].borderColor;
                });
                projectChart.update('none');
            }
            
            if (issueChart) {
                const resolvedData = resolveChartColors(originalIssueData);
                issueChart.data.datasets.forEach((dataset, index) => {
                    dataset.backgroundColor = resolvedData.data.datasets[index].backgroundColor;
                    dataset.borderColor = resolvedData.data.datasets[index].borderColor;
                });
                issueChart.update('none');
            }
        };
        
        // Theme change listeners
        new MutationObserver(mutations => 
            mutations.some(m => m.type === 'attributes' && m.attributeName === 'data-theme') && 
            setTimeout(updateAllChartColors, 100)
        ).observe(document.documentElement, { attributes: true, attributeFilter: ['data-theme'] });
        
        document.addEventListener('click', e => 
            (e.target.classList.contains('theme-controller') || e.target.closest('.theme-controller')) && 
            setTimeout(updateAllChartColors, 100)
        );
    });
    </script>
@endpush