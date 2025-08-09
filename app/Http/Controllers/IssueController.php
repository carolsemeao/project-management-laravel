<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Issue;
use App\Models\User;
use App\Models\Project;
use App\Models\Status;
use App\Models\Priority;

class IssueController extends Controller
{
    public function ShowIssues()
    {
        $user = Auth::user();
        $projects = $user->projects()->get();

        // Get the closed status ID
        $closedStatus = Status::where('name', 'closed')->first();
        
        // Get issues that are either:
        // 1. Created by the current user AND have no project assigned, OR
        // 2. Assigned to the current user (regardless of project)
        // AND exclude closed issues
        $issues = Issue::where(function($query) use ($user) {
                    $query->where(function($subQuery) use ($user) {
                        $subQuery->where('created_by_user_id', $user->id)
                                ->whereNull('project_id');
                        })
                        ->orWhere('assigned_to_user_id', $user->id);
                    })
                    ->when($closedStatus, function($query) use ($closedStatus) {
                        $query->where('status_id', '!=', $closedStatus->id);
                    })
                    ->with(['assignedUser', 'createdByUser', 'project', 'status', 'priority'])
                    ->orderBy('created_at', 'desc')
                    ->get();
                      
        return view('admin.issue.admin_issues', compact('issues', 'projects'));
    }

    public function ShowSingleIssue($id)
    {
        $issue = Issue::with([
            'assignedUser', 
            'createdByUser', 
            'project', 
            'project.createdBy',
            'timeEntries.user'
        ])->findOrFail($id);
        
        // Check if user can view this issue
        if (!$this->userCanViewIssue($issue, Auth::user())) {
            abort(403, 'You do not have permission to view this issue');
        }
        
        return view('admin.issue.admin_issue_single', compact('issue'));
    }

    /**
     * Check if user can view an issue
     */
    private function userCanViewIssue($issue, $user)
    {
        // User can view the issue if:
        // 1. The issue belongs to a project they're assigned to (regardless of assignee)
        // 2. (Optional) They have 'can_view_issues' permission (admin override)

        if ($issue->created_by_user_id === $user->id) {
            return true;
        }

        if ($issue->assigned_to_user_id === $user->id) {
            return true;
        }

        if ($issue->project_id && $user->isAssignedToProject($issue->project_id)) {
            return true;
        }

        // Admin override: user has global permission
        if ($user->hasPermission('can_view_issues')) {
            return true;
        }

        // Otherwise, deny access
        return false;
    }

    /**
     * Check if user can modify an issue
     */
    private function userCanModifyIssue($issue, $user)
    {
        // User can modify if:
        // 1. They have 'can_assign_issues' permission (Project Managers)
        // 2. They created the issue
        // 3. Issue is assigned to them directly
        // 4. They are assigned to the project (can edit any issue in their project)
        
        if ($user->hasPermission('can_assign_issues')) {
            return true;
        }
        
        if ($issue->created_by_user_id === $user->id) {
            return true;
        }
        
        if ($issue->assigned_to_user_id === $user->id) {
            return true;
        }
        
        // Check if user is assigned to the project
        if ($issue->project_id && $user->isAssignedToProject($issue->project_id)) {
            return true;
        }
        
        return false;
    }

    public function ShowSingleIssueEdit($id)
    {
        $issue = Issue::findOrFail($id);
        
        // Check if user can modify this issue
        if (!$this->userCanModifyIssue($issue, Auth::user())) {
            abort(403, 'You do not have permission to edit this issue');
        }
        
        // Get data for dropdowns
        if (is_null($issue->project_id)) {
            // Only show projects the user is assigned to
            $projects = Auth::user()->projects ?? collect();
        } else {
            $projects = Project::all();
        }
        
        // Get users assigned to the project this issue belongs to
        $users = collect();
        if ($issue->project_id) {
            $project = Project::find($issue->project_id);
            if ($project) {
                $users = $project->users;
            }
        }
        
        // Fallback: if no users found for the project, add the currently logged in user
        if ($users->isEmpty()) {
            $users = collect([Auth::user()]);
        }
        
        $statuses = Status::all();
        $priorities = Priority::all();
        
        return view('admin.issue.admin_issue_single_edit', compact('issue', 'projects', 'users', 'statuses', 'priorities'));
    }

    /**
     * Update an issue
     */
    public function UpdateIssue(Request $request, $id)
    {
        $request->validate([
            'issue_title' => 'required|string|max:255',
            'issue_description' => 'nullable|string',
            'status_id' => 'required|integer|exists:status,id',
            'priority_id' => 'required|integer|exists:priorities,id',
            'project_id' => 'nullable|integer|exists:projects,id',
            'assigned_to_user_id' => 'nullable|integer|exists:users,id',
            'issue_due_date' => 'nullable|date',
            'estimated_time_hours' => 'nullable|numeric|min:0',
        ], [
            'issue_title.required' => __('Please set a title'),
            'issue_title.max' => __('The title must be less than 255 characters'),
            'status_id.required' => __('Please set a status'),
            'priority_id.required' => __('Please set a priority'),
        ]);

        $issue = Issue::findOrFail($id);
        
        // Check if user has permission to update this issue
        if (!$this->userCanModifyIssue($issue, Auth::user())) {
            return redirect()->back()->with([
                'message' => __('You do not have permission to update this issue'),
                'alert-type' => 'warning'
            ]);
        }

        // Convert hours to minutes
        $estimatedTimeMinutes = null;
        if ($request->filled('estimated_time_hours')) {
            $estimatedTimeMinutes = round($request->estimated_time_hours * 60);
        }

        $issue->update([
            'issue_title' => $request->issue_title,
            'issue_description' => $request->issue_description,
            'status_id' => $request->status_id,
            'priority_id' => $request->priority_id,
            'project_id' => $request->project_id,
            'assigned_to_user_id' => $request->assigned_to_user_id,
            'issue_due_date' => $request->issue_due_date,
            'estimated_time_minutes' => $estimatedTimeMinutes,
        ]);

        return redirect()->back()->with([
            'message' => 'Issue updated successfully!',
            'alert-type' => 'success'
        ]);
    }

    public function DeleteIssue($id)
    {
        $issue = Issue::findOrFail($id);

        if (!$this->userCanModifyIssue($issue, Auth::user())) {
            return redirect()->back()->with([
                'message' => 'You do not have permission to delete this issue',
                'alert-type' => 'warning'
            ]);
        }

        $issue->delete();

        return redirect()->route('admin.issues')->with([
            'message' => 'Issue deleted successfully!',
            'alert-type' => 'success'
        ]);
    }

    public function CloseIssue($id)
    {
        $issue = Issue::findOrFail($id);
        if (!$this->userCanModifyIssue($issue, Auth::user())) {
            return redirect()->back()->with([
                'message' => 'You do not have permission to close this issue',
                'alert-type' => 'warning'
            ]);
        }
        
        $closedStatusId = Status::where('name', 'closed')->value('id');
        $issue->update([
            'status_id' => $closedStatusId
        ]);

        return redirect()->back()->with([
            'message' => 'Issue closed successfully!',
            'alert-type' => 'success'
        ]);
    }

    public function CreateIssue(Request $request)
    {
        $request->validate([
            'issue_title' => 'required|string|max:255',
            'issue_description' => 'nullable|string',
            'status_id' => 'required|integer|exists:status,id',
            'priority_id' => 'required|integer|exists:priorities,id',
            'project_id' => 'nullable|integer|exists:projects,id',
            'assigned_to_user_id' => 'nullable|integer|exists:users,id',
            'issue_due_date' => 'nullable|date',
            'estimated_time_hours' => 'nullable|numeric|min:0',
            'created_by_user_id' => 'nullable|integer|exists:users,id',
        ], [
            'issue_title.required' => 'Please set a title',
            'issue_title.max' => 'The title must be less than 255 characters',
            'status_id.required' => 'Please set a status',
            'priority_id.required' => 'Please set a priority',
        ]);

        // Convert hours to minutes
        $estimatedTimeMinutes = null;
        if ($request->filled('estimated_time_hours')) {
            $estimatedTimeMinutes = round($request->estimated_time_hours * 60);
        }

        $issue = Issue::create([
            'issue_title' => $request->issue_title,
            'issue_description' => $request->issue_description,
            'status_id' => $request->status_id,
            'priority_id' => $request->priority_id,
            'project_id' => $request->project_id,
            'assigned_to_user_id' => $request->assigned_to_user_id,
            'issue_due_date' => $request->issue_due_date,
            'estimated_time_minutes' => $estimatedTimeMinutes,
            'created_by_user_id' => Auth::user()->id,
        ]);

        $issue->save();

        return redirect()->route('admin.issues')->with([
            'message' => 'Issue created successfully!',
            'alert-type' => 'success'
        ]);
    }

    public function ShowCreateIssue()
    {
        $user = Auth::user();
        $userProjects = $user->projects()->pluck('projects.id');
        
        // Get users assigned to the project this issue belongs to
        $projects = Project::all();
        if ($userProjects) {
            $projects = Project::whereIn('id', $userProjects)->get();
        }
        $statuses = Status::all();
        $priorities = Priority::all();
        $users = User::all();

        return view('admin.issue.admin_issue_create', compact('projects', 'statuses', 'priorities', 'users'));
    }
}
