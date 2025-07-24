<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\ChartService;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    protected ChartService $chartService;

    public function __construct(ChartService $chartService)
    {
        $this->chartService = $chartService;
    }

    /**
     * Get dashboard charts data
     */
    public function getDashboardCharts()
    {
        return [
            'projectStatusChart' => $this->chartService->createProjectStatusChart(),
            'issueStatusBarChart' => $this->chartService->createIssuesStatusBarChart(),
        ];
    }

    /**
     * Get project-specific charts data
     */
    public function getProjectCharts($projectId = null)
    {
        // Handle both Project model and project ID
        if ($projectId instanceof Project) {
            $project = $projectId;
        } else {
            $project = Project::findOrFail($projectId);
        }

        return [
            'issueStatusChart' => $this->chartService->createProjectIssueStatusChart($project),
            'issuePriorityChart' => $this->chartService->createProjectIssuePriorityChart($project),
        ];
    }

    /**
     * API endpoint to get chart data as JSON
     */
    public function getChartData(Request $request)
    {
        $type = $request->input('type', 'status');
        $projectId = $request->input('project_id');

        switch ($type) {
            case 'project_status':
                // Dashboard: Project status distribution (pie chart)
                $chart = $this->chartService->createProjectStatusChart();
                break;

            case 'issue_status_bar':
                // Dashboard: Issue status overview (bar chart)
                $chart = $this->chartService->createIssuesStatusBarChart();
                break;

            case 'project_issue_status':
                // Project page: Issue status distribution (pie chart)
                if (!$projectId) {
                    return response()->json(['error' => 'Project ID required'], 400);
                }
                $project = Project::findOrFail($projectId);
                $chart = $this->chartService->createProjectIssueStatusChart($project);
                break;

            case 'project_priority':
                // Project page: Priority distribution (bar chart)
                if (!$projectId) {
                    return response()->json(['error' => 'Project ID required'], 400);
                }
                $project = Project::findOrFail($projectId);
                $chart = $this->chartService->createProjectIssuePriorityChart($project);
                break;

            default:
                return response()->json(['error' => 'Invalid chart type. Use: project_status, issue_status_bar, project_issue_status, or project_priority'], 400);
        }

        if (is_array($chart)) {
            // If $chart is an array, try to render each chart and return as array
            $rendered = [];
            foreach ($chart as $key => $chartObj) {
                if (is_object($chartObj) && method_exists($chartObj, 'render')) {
                    $rendered[$key] = $chartObj->render();
                } else {
                    $rendered[$key] = $chartObj;
                }
            }
            return response()->json(['chart' => $rendered]);
        } else {
            return response()->json(['chart' => $chart->render()]);
        }
    }

    /**
     * Get available chart colors
     */
    public function getChartColors()
    {
        return response()->json([
            'status_colors' => $this->chartService->getStatusColors(),
            'priority_colors' => $this->chartService->getPriorityColors(),
        ]);
    }
}
