<?php

namespace App\Services;

use App\Models\Issue;
use App\Models\Project;
use App\Models\Status;
use App\Models\Priority;
use Illuminate\Support\Facades\DB;

class ChartService
{
    /**
     * Default color mapping for issue statuses
     */
    protected array $statusColors = [
        'planned' => '#748DAE', 
        'in_progress' => '#F5CBCB',
        'waiting_for_planning' => '#9ECAD6',
        'on_hold' => '#F4D4A7',        
        'feedback' => '#FFEAEA',
        'closed' => '#B8E6B8',
        'resolved' => '#A8E6CF',  // Slightly brighter sage green - successful resolution
        'rejected' => '#E8B4B8',
    ];

    /**
     * Default color mapping for issue priorities
     */
    protected array $priorityColors = [
        'low' => '#9ECAD6',
        'normal' => '#748DAE',
        'high' => '#F5CBCB',
        'urgent' => '#FFEAEA',
        'immediate' => '#E0D4F7',
    ];

    /**
     * Create project-specific issue priority chart data (BAR CHART)
     */
    public function createProjectIssuePriorityChart(Project $project): array
    {
        $projectPriorityDistribution = $project->issues()
            ->join('priorities', 'issues.priority_id', '=', 'priorities.id')
            ->select('priorities.name', 'priorities.color', DB::raw('count(*) as total'))
            ->groupBy('priorities.id', 'priorities.name', 'priorities.color')
            ->get();

        // Handle empty data
        if ($projectPriorityDistribution->isEmpty()) {
            return $this->createEmptyChartData('No priority data available');
        }

        $labels = $projectPriorityDistribution->map(fn($item) => ucfirst($item->name ?? 'Unknown'))->toArray();
        $data = $projectPriorityDistribution->pluck('total')->toArray();
        $colors = $projectPriorityDistribution->map(fn($item) => $item->color ?? '#6c757d')->toArray();

        return [
            'type' => 'bar',
            'data' => [
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => 'Issues by Priority',
                        'data' => $data,
                        'backgroundColor' => $colors,
                        'borderColor' => $colors,
                        'borderWidth' => 1,
                    ]
                ]
            ],
            'options' => [
                'interaction' => [
                    'includeInvisible' => true,
                ],
                'responsive' => true,
                'maintainAspectRatio' => false,
                'plugins' => [
                    'legend' => [
                        'display' => false
                    ]
                ],
                'scales' => [
                    'y' => [
                        'beginAtZero' => true
                    ]
                ],
                'animation' => [
                    'delay' => 500
                ]
            ]
        ];
    }

    /**
     * Create project-specific issue status chart data (PIE CHART)
     */
    public function createProjectIssueStatusChart(Project $project): array
    {
        $projectIssueDistribution = $project->issues()
            ->join('status', 'issues.status_id', '=', 'status.id')
            ->select('status.name', DB::raw('count(*) as total'))
            ->groupBy('status.id', 'status.name')
            ->get();

        // Handle empty data
        if ($projectIssueDistribution->isEmpty()) {
            return $this->createEmptyChartData('No issues found for this project');
        }

        $labels = $projectIssueDistribution->map(fn($item) => ucwords(str_replace('_', ' ', $item->name ?? 'Unknown')))->toArray();
        $data = $projectIssueDistribution->pluck('total')->toArray();
        $colors = $projectIssueDistribution->map(fn($item) => $this->statusColors[$item->name ?? 'unknown'] ?? '#6c757d')->toArray();

        return [
            'type' => 'pie',
            'data' => [
                'labels' => $labels,
                'datasets' => [
                    [
                        'data' => $data,
                        'backgroundColor' => $colors,
                        'borderWidth' => 2,
                        'borderColor' => '#fff',
                    ]
                ]
            ],
            'options' => [
                'interaction' => [
                    'includeInvisible' => true,
                ],
                'responsive' => true,
                'maintainAspectRatio' => false,
                'plugins' => [
                    'legend' => [
                        'position' => 'bottom'
                    ],
                ],
                'animation' => [
                    'delay' => 500
                ],
                'hoverOffset' => 10
            ]
        ];
    }

    /**
     * Create issues by status bar chart data
     */
    public function createIssuesStatusBarChart(): array
    {
        $statusData = Issue::join('status', 'issues.status_id', '=', 'status.id')
            ->select('status.name', DB::raw('count(*) as total'))
            ->groupBy('status.id', 'status.name')
            ->get();

        // Handle empty data
        if ($statusData->isEmpty()) {
            return $this->createEmptyChartData('No status data available');
        }

        $labels = $statusData->map(fn($item) => ucwords(str_replace('_', ' ', $item->name ?? 'Unknown')))->toArray();
        $data = $statusData->pluck('total')->toArray();
        $colors = $statusData->map(fn($item) => $this->statusColors[$item->name ?? 'unknown'] ?? '#6c757d')->toArray();

        return [
            'type' => 'bar',
            'data' => [
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => 'Issues by Status',
                        'data' => $data,
                        'backgroundColor' => $colors,
                        'borderColor' => $colors,
                        'borderWidth' => 1,
                    ]
                ]
            ],
            'options' => [
                'interaction' => [
                    'includeInvisible' => true,
                ],
                'responsive' => true,
                'maintainAspectRatio' => false,
                'plugins' => [
                    'legend' => [
                        'display' => false
                    ]
                ],
                'scales' => [
                    'y' => [
                        'beginAtZero' => true
                    ]
                ],
                'animation' => [
                    'delay' => 500
                ]
            ]
        ];
    }

    /**
     * Create project status distribution pie chart data
     */
    public function createProjectStatusChart(): array
    {
        $projectStatusDistribution = Project::join('project_statuses', 'projects.status_id', '=', 'project_statuses.id')
            ->select('project_statuses.name', DB::raw('count(*) as total'))
            ->groupBy('project_statuses.id', 'project_statuses.name')
            ->get();

        // Handle empty data
        if ($projectStatusDistribution->isEmpty()) {
            return $this->createEmptyChartData('No project data available');
        }

        $statusColorMapping = [
            'planning' => '#748DAE',
            'active' => '#F5CBCB', 
            'on_hold' => '#F4D4A7',
            'completed' => '#B8E6B8',
            'cancelled' => '#9ECAD6'
        ];

        $labels = $projectStatusDistribution->map(fn($item) => ucwords(str_replace('_', ' ', $item->name ?? 'Unknown')))->toArray();
        $data = $projectStatusDistribution->pluck('total')->toArray();
        $colors = $projectStatusDistribution->map(fn($item) => $item->color ?? $statusColorMapping[$item->name ?? 'unknown'] ?? '#6c757d')->toArray();

        return [
            'type' => 'pie',
            'data' => [
                'labels' => $labels,
                'datasets' => [
                    [
                        'data' => $data,
                        'backgroundColor' => $colors,
                        'borderWidth' => 1,
                        'borderColor' => '#fff',
                    ]
                ]
            ],
            'options' => [
                'interaction' => [
                    'includeInvisible' => true,
                ],
                'responsive' => true,
                'maintainAspectRatio' => false,
                'plugins' => [
                    'legend' => [
                        'position' => 'bottom'
                    ],
                ],
                'animation' => [
                    'delay' => 500
                ],
                'hoverOffset' => 10
            ]
        ];
    }

    /**
     * Create an empty chart when no data is available
     */
    protected function createEmptyChartData(string $message = 'No data'): array
    {
        return [
            'type' => 'pie',
            'data' => [
                'labels' => [$message],
                'datasets' => [
                    [
                        'data' => [1],
                        'backgroundColor' => ['#e9ecef'],
                        'borderWidth' => 0,
                    ]
                ]
            ],
            'options' => [
                'responsive' => true,
                'maintainAspectRatio' => false,
                'plugins' => [
                    'legend' => [
                        'display' => false
                    ],
                    'tooltip' => [
                        'enabled' => false
                    ]
                ]
            ]
        ];
    }

    /**
     * Get available status colors
     */
    public function getStatusColors(): array
    {
        return $this->statusColors;
    }

    /**
     * Get available priority colors
     */
    public function getPriorityColors(): array
    {
        return $this->priorityColors;
    }

    /**
     * Add or update a status color
     */
    public function setStatusColor(string $status, string $color): void
    {
        $this->statusColors[$status] = $color;
    }

    /**
     * Add or update a priority color
     */
    public function setPriorityColor(string $priority, string $color): void
    {
        $this->priorityColors[$priority] = $color;
    }
} 