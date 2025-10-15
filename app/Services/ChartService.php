<?php

namespace App\Services;

use App\Models\Issue;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

class ChartService
{
    /**
     * Default color mapping for issue statuses
     */
    protected array $statusColors = [
        'planned' => 'var(--status-planned-color)', // Primary color
        'in_progress' => 'var(--status-in_progress-color)', // Secondary color
        'waiting_for_planning' => 'var(--status-waiting_for_planning-color)', // Accent color
        'on_hold' => 'var(--status-on_hold-color)', // Error color        
        'feedback' => 'var(--status-feedback-color)', // Warning color
        'closed' => 'var(--status-closed-color)', // Success color
        'resolved' => 'var(--status-resolved-color)', // Info color
        'rejected' => 'var(--status-rejected-color)', // Error color
    ];

    /**
     * Default color mapping for issue priorities
     */
    /* protected array $priorityColors = [
        'low' => '#9ECAD6',
        'normal' => '#748DAE',
        'high' => '#F5CBCB',
        'urgent' => '#FFEAEA',
        'immediate' => '#E0D4F7',
    ]; */

    protected array $priorityColors = [
        'low' => 'var(--priority-low)',
        'normal' => 'var(--priority-normal)', 
        'high' => 'var(--priority-high)',
        'urgent' => 'var(--priority-urgent)',
        'immediate' => 'var(--priority-immediate)',
    ];

    /**
     * Create project-specific issue priority chart data (BAR CHART)
     */
    public function createProjectIssuePriorityChart(Project $project): array
    {
        $projectPriorityDistribution = $project->issues()
            ->join('issue_priorities', 'issues.priority_id', '=', 'issue_priorities.id')
            ->select('issue_priorities.name', DB::raw('count(*) as total'))
            ->groupBy('issue_priorities.id', 'issue_priorities.name')
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
                        'beginAtZero' => true,
                        'ticks' => [
                            'stepSize' => 1,
                        ]
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
            ->join('issue_status', 'issues.status_id', '=', 'issue_status.id')
            ->select('issue_status.name', DB::raw('count(*) as total'))
            ->groupBy('issue_status.id', 'issue_status.name')
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
     * Create issues by status bar chart data for a specific user
     */
    public function createIssuesStatusBarChart($userId = null): array
    {
        // Get all statuses first
        $allStatusesFromDb = DB::table('issue_status')->orderBy('name')->get();

        // For each status, count issues with user filter
        $allStatuses = $allStatusesFromDb->map(function ($status) use ($userId) {
            $query = DB::table('issues')->where('status_id', $status->id);

            // Filter by user if provided
            if ($userId) {
                $query->where(function ($q) use ($userId) {
                    $q->where('assigned_to_user_id', $userId)
                      ->orWhere('created_by_user_id', $userId);
                });
            }

            $count = $query->count();

            return (object) [
                'name' => $status->name,
                'total' => $count
            ];
        });

        // Handle empty statuses
        if ($allStatuses->isEmpty()) {
            return $this->createEmptyChartData('No status data available');
        }

        $labels = $allStatuses->map(fn($item) => ucwords(str_replace('_', ' ', $item->name ?? 'Unknown')))->toArray();
        $data = $allStatuses->pluck('total')->toArray();
        $colors = $allStatuses->map(fn($item) => $this->statusColors[$item->name ?? 'unknown'] ?? '#6c757d')->toArray();

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
                        'display' => false,
                        'labels' => [
                            'font' => [
                                'size' => 10
                            ]
                        ]
                    ]
                ],
                'scales' => [
                    'y' => [
                        
                        'beginAtZero' => true,
                        'grid' => [
                            'lineWidth' => 0,
                            
                        ],
                        'ticks' => [
                            'stepSize' => 1,
                        ]
                    ],
                ],
                'animation' => [
                    'delay' => 500
                ]
            ]
        ];
    }

    /**
     * Create project status distribution pie chart data for a specific user
     */
    public function createProjectStatusChart($userId = null): array
    {
        $query = Project::join('project_statuses', 'projects.status_id', '=', 'project_statuses.id')
            ->select('project_statuses.name', DB::raw('count(*) as total'));

        // Filter by user if provided - only show projects the user is assigned to
        if ($userId) {
            $query->join('project_user', 'projects.id', '=', 'project_user.project_id')
                  ->where('project_user.user_id', $userId)
                  ->whereNull('project_user.removed_at');
        }

        $projectStatusDistribution = $query
            ->groupBy('project_statuses.id', 'project_statuses.name')
            ->get();

        // Handle empty data
        if ($projectStatusDistribution->isEmpty()) {
            return $this->createEmptyChartData('No project data available');
        }

        $statusColorMapping = [
            'planning' => 'var(--priority-low)',
            'active' => 'var(--priority-normal)', 
            'on_hold' => 'var(--priority-high)',
            'completed' => 'var(--priority-urgent)',
            'cancelled' => 'var(--priority-immediate)',
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
                        'borderColor' => '#f8f3fd',
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