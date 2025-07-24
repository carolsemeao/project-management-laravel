<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Project;

class ProjectsController extends Controller
{
    public function ShowProjects()
    {
        $projects = Project::all();
        return view('admin.project.admin_projects', compact('projects'));
    }

    public function ShowSingleProject($id)
    {
        $project = Project::findOrFail($id);
        
        // Generate charts for the analytics tab (like dashboard approach)
        $chartController = app(ChartController::class);
        
        try {
            $projectCharts = $chartController->getProjectCharts($project->id);
            $projectIssueStatusChart = $projectCharts['issueStatusChart'];
            $projectIssuePriorityChart = $projectCharts['issuePriorityChart'];            
        } catch (\Exception $e) {
            // Fallback to empty values
            $projectIssueStatusChart = null;
            $projectIssuePriorityChart = null;
        }
        
        return view('admin.project.admin_project_single', compact('project', 'projectIssueStatusChart', 'projectIssuePriorityChart'));
    }
}
