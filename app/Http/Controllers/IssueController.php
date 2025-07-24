<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Issue;
use App\Models\User;

class IssueController extends Controller
{
    public function ShowIssues()
    {
        // Get issues assigned to the user or created by the user
        $issues = Issue::where('assigned_to_user_id', Auth::id())
                      ->orWhere('created_by_user_id', Auth::id())
                      ->with(['assignedUser', 'createdByUser', 'project'])
                      ->orderBy('created_at', 'desc')
                      ->get();
                      
        return view('admin.issue.admin_issues', compact('issues'));
    }

    public function UpdateStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'status_id' => 'required|integer|exists:status,id'
            ]);

            $issue = Issue::findOrFail($id);
            
            // Check if user has permission to update this issue
            if (!$this->userCanModifyIssue($issue, Auth::user())) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have permission to update this issue'
                ], 403);
            }
            
            $issue->update([
                'status_id' => $request->status_id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully',
                'new_status' => $request->status
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status: ' . $e->getMessage()
            ], 500);
        }
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
     * Update issue assignment (user only)
     */
    public function UpdateAssignment(Request $request, $id)
    {
        try {
            $request->validate([
                'assigned_to_user_id' => 'nullable|exists:users,id',
            ]);

            $issue = Issue::findOrFail($id);
            
            // Check permissions
            if (!$this->userCanModifyIssue($issue, Auth::user())) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have permission to assign this issue'
                ], 403);
            }

            $issue->update([
                'assigned_to_user_id' => $request->assigned_to_user_id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Assignment updated successfully',
                'assignee_name' => $issue->fresh(['assignedUser'])->assignedUser?->name ?? 'Unassigned'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update assignment: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check if user can view an issue
     */
    private function userCanViewIssue($issue, $user)
    {
        // User can view if:
        // 1. Issue is assigned to them directly
        // 2. They created the issue
        // 3. Issue belongs to a project they're assigned to
        // 4. They have 'can_view_issues' permission
        
        if ($issue->assigned_to_user_id === $user->id || $issue->created_by_user_id === $user->id) {
            return true;
        }
        
        // Check if user is assigned to the issue's project
        if ($issue->project_id && $user->isAssignedToProject($issue->project_id)) {
            return true;
        }
        
        // Check if user has general view permission
        if ($user->hasPermission('can_view_issues')) {
            return true;
        }
        
        // If none of the above, deny access
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
        
        if ($user->hasPermission('can_assign_issues')) {
            return true;
        }
        
        if ($issue->created_by_user_id === $user->id) {
            return true;
        }
        
        if ($issue->assigned_to_user_id === $user->id) {
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
        $projects = \App\Models\Project::all();
        $users = User::all();
        $statuses = \App\Models\Status::all();
        $priorities = \App\Models\Priority::all();
        
        return view('admin.issue.admin_issue_single_edit', compact('issue', 'projects', 'users', 'statuses', 'priorities'));
    }

    /**
     * Update an issue
     */
    public function UpdateIssue(Request $request, $id)
    {
        try {
            $request->validate([
                'issue_title' => 'required|string|max:255',
                'issue_description' => 'nullable|string',
                'status_id' => 'required|integer|exists:status,id',
                'priority_id' => 'required|integer|exists:priorities,id',
                'project_id' => 'nullable|integer|exists:projects,id',
                'assigned_to_user_id' => 'nullable|integer|exists:users,id',
                'issue_due_date' => 'nullable|date',
                'estimated_time_hours' => 'nullable|numeric|min:0',
            ]);

            $issue = Issue::findOrFail($id);
            
            // Check if user has permission to update this issue
            if (!$this->userCanModifyIssue($issue, Auth::user())) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have permission to update this issue'
                ], 403);
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

            return response()->json([
                'success' => true,
                'message' => 'Issue updated successfully',
                'issue' => $issue->fresh(['status', 'priority', 'project', 'assignedUser'])
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update issue: ' . $e->getMessage()
            ], 500);
        }
    }
}
