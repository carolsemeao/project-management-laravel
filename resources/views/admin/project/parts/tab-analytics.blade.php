<div class="row mt-3">
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Issue Status Distribution</h5>
                <div class="chart-container d-flex justify-content-center" style="height: 250px;">
                    @if(isset($projectIssueStatusChart))
                        <canvas id="projectIssueStatusChart" width="250" height="250"></canvas>
                    @else
                        <div class="alert alert-info">
                            <p class="mb-0">No issue status data available for this project</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Priority Distribution</h5>
                <div class="chart-container d-flex justify-content-center" style="height: 250px;">
                    @if(isset($projectIssuePriorityChart))
                        <canvas id="projectIssuePriorityChart" width="250" height="250"></canvas>
                    @else
                        <div class="alert alert-info">
                            <p class="mb-0">No priority data available for this project</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if(isset($projectIssueStatusChart) || isset($projectIssuePriorityChart))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(isset($projectIssueStatusChart))
                // Issue Status Chart
                const statusCtx = document.getElementById('projectIssueStatusChart');
                if (statusCtx) {
                    const statusChart = new Chart(statusCtx, @json($projectIssueStatusChart));

                    // Reset animation delay after initial animation completes
                    setTimeout(() => {
                        statusChart.options.animation.delay = undefined;
                    }, 1000); // Wait for initial animation + delay to complete
                }
            @endif

                @if(isset($projectIssuePriorityChart))
                    // Priority Chart
                    const priorityCtx = document.getElementById('projectIssuePriorityChart');
                    if (priorityCtx) {
                        const priorityChart = new Chart(priorityCtx, @json($projectIssuePriorityChart));

                        // Reset animation delay after initial animation completes
                        setTimeout(() => {
                            priorityChart.options.animation.delay = undefined;
                        }, 1000); // Wait for initial animation + delay to complete
                    }
                @endif
                });
    </script>
@endif