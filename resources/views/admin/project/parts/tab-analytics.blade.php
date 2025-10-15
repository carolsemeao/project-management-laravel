<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">
    <div>
        <h3>{{ __('Issue Status Distribution') }}</h3>
        @if(isset($projectIssueStatusChart))
            <div class="chart-container flex justify-center" style="height: 250px;">
                <canvas id="projectIssueStatusChart" width="250" height="250"></canvas>
            </div>
        @else
            <div class="empty h-full flex flex-col justify-center items-center">
                <span class="icon icon-lg icon-bug mb-2 block"></span>
                <p class="text-sm">{{ __('No issue data available for this project') }}</p>
                <p class="text-xs mt-1">{{ __('Create your first issue for this project') }}</p>
                <a href="{{ route('admin.issues.create', ['project_id' => $project->id]) }}" class="btn mt-3">
                    <span class="icon icon-sm icon-plus me-2"></span>
                    {{ __('Create Issue') }}
                </a>
            </div>
        @endif
    </div>
    <div>
        <h3>{{ __('Priority Distribution') }}</h3>
        @if(isset($projectIssuePriorityChart))
            <div class="chart-container d-flex justify-content-center" style="height: 250px;">
                <canvas id="projectIssuePriorityChart" width="250" height="250"></canvas>
            </div>
        @else
            <div class="empty h-full flex flex-col justify-center items-center">
                <span class="icon icon-lg icon-bug mb-2 block"></span>
                <p class="text-sm">{{ __('No issue data available for this project') }}</p>
                <p class="text-xs mt-1">{{ __('Create your first issue for this project') }}</p>
                <a href="{{ route('admin.issues.create', ['project_id' => $project->id]) }}" class="btn mt-3">
                    <span class="icon icon-sm icon-plus me-2"></span>
                    {{ __('Create Issue') }}
                </a>
            </div>
        @endif
    </div>
</div>