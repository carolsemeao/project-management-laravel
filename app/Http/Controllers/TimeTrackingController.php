<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Issue;
use App\Models\TimeEntry;
use App\Models\Project;
use Carbon\Carbon;

class TimeTrackingController extends Controller
{
    /**
     * Log time for an issue
     */
    public function logTime(Request $request, $issueId)
    {
        try {
            $request->validate([
                'time_input' => 'required|string',
                'description' => 'nullable|string|max:500',
                'work_date' => 'nullable|date|before_or_equal:today',
            ]);

            $issue = Issue::findOrFail($issueId);
            
            // Check if user can log time for this issue
            if (!$this->userCanLogTime($issue, Auth::user())) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have permission to log time for this issue'
                ], 403);
            }

            // Parse time input
            try {
                $timeEntry = $issue->logTime(
                    Auth::id(),
                    $request->time_input,
                    $request->description,
                    $request->work_date ?: now()->toDateString()
                );
            } catch (\InvalidArgumentException $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid time format. Use formats like "1h 30m", "90m", "1.5h", etc.'
                ], 400);
            }

            return redirect()->back()->with([
                'message' => 'Time logged successfully',
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'message' => 'Failed to log time: ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Set estimated time for an issue
     */
    public function setEstimate(Request $request, $issueId)
    {
        try {
            $request->validate([
                'estimated_time' => 'required|string',
            ]);

            $issue = Issue::findOrFail($issueId);
            
            // Check if user can set estimates
            if (!$this->userCanSetEstimate($issue, Auth::user())) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have permission to set estimates for this issue'
                ], 403);
            }

            try {
                $issue->setEstimatedTime($request->estimated_time);
            } catch (\InvalidArgumentException $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid time format. Use formats like "1h 30m", "90m", "1.5h", etc.'
                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => 'Estimate updated successfully',
                'estimated_time' => $issue->fresh()->formatted_estimated_time,
                'issue_progress' => [
                    'logged_time' => $issue->formatted_logged_time,
                    'estimated_time' => $issue->formatted_estimated_time,
                    'percentage' => $issue->getTimeProgressPercentage(),
                    'status' => $issue->getTimeTrackingStatus(),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to set estimate: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get time entries for an issue
     */
    public function getTimeEntries($issueId)
    {
        try {
            $issue = Issue::findOrFail($issueId);
            
            // Check if user can view time entries
            if (!$this->userCanViewTimeEntries($issue, Auth::user())) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have permission to view time entries for this issue'
                ], 403);
            }

            $timeEntries = $issue->timeEntries()
                               ->with('user')
                               ->get()
                               ->map(function ($entry) {
                                   return [
                                       'id' => $entry->id,
                                       'formatted_time' => $entry->formatted_time,
                                       'description' => $entry->description,
                                       'work_date' => $entry->work_date->format('d/m/Y'),
                                       'user_name' => $entry->user->name,
                                       'logged_at' => $entry->logged_at->format('d/m/Y H:i'),
                                   ];
                               });

            return response()->json([
                'success' => true,
                'time_entries' => $timeEntries,
                'summary' => [
                    'total_logged' => $issue->formatted_logged_time,
                    'estimated' => $issue->formatted_estimated_time,
                    'remaining' => $issue->formatted_remaining_time,
                    'percentage' => $issue->getTimeProgressPercentage(),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get time entries: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a time entry
     */
    public function deleteTimeEntry($entryId)
    {
        try {
            $timeEntry = TimeEntry::findOrFail($entryId);
            $issue = $timeEntry->issue;
            
            // Check if user can delete this time entry
            if (!$this->userCanDeleteTimeEntry($timeEntry, Auth::user())) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have permission to delete this time entry'
                ], 403);
            }

            $timeEntry->delete();
            
            // Update cached logged time
            $issue->update([
                'logged_time_minutes' => $issue->getTotalLoggedTimeMinutes()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Time entry deleted successfully',
                'issue_progress' => [
                    'logged_time' => $issue->fresh()->formatted_logged_time,
                    'estimated_time' => $issue->formatted_estimated_time,
                    'percentage' => $issue->getTimeProgressPercentage(),
                    'status' => $issue->getTimeTrackingStatus(),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete time entry: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's time summary
     */
    public function getUserTimeSummary(Request $request)
    {
        $user = Auth::user();
        $startDate = $request->get('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->get('end_date', now()->endOfMonth()->toDateString());

        $timeByProject = $user->getTimeByProject($startDate, $endDate);
        $totalMinutes = $user->getTotalLoggedTimeMinutes($startDate, $endDate);

        return response()->json([
            'success' => true,
            'summary' => [
                'period' => [
                    'start' => $startDate,
                    'end' => $endDate,
                ],
                'total_time' => TimeEntry::formatMinutes($totalMinutes),
                'total_minutes' => $totalMinutes,
                'projects' => $timeByProject,
            ]
        ]);
    }

    /**
     * Check if user can log time for an issue
     */
    private function userCanLogTime($issue, $user)
    {
        // User can log time if:
        // 1. Issue is assigned to them directly
        // 2. They're assigned to the project
        // 3. They have permission to edit issues
        
        if ($issue->assigned_to_user_id === $user->id) {
            return true;
        }
        
        if ($issue->project_id && $user->isAssignedToProject($issue->project_id)) {
            return true;
        }
        
        return $user->hasPermission('can_edit_issues');
    }

    /**
     * Check if user can set estimates
     */
    private function userCanSetEstimate($issue, $user)
    {
        // User can set estimates if:
        // 1. They have 'can_assign_issues' permission (project managers)
        // 2. They created the issue
        // 3. Issue is assigned to them directly
        // 4. They're assigned to the project and have edit permissions
        
        if ($user->hasPermission('can_assign_issues')) {
            return true;
        }
        
        if ($issue->created_by_user_id === $user->id) {
            return true;
        }
        
        if ($issue->assigned_to_user_id === $user->id) {
            return true;
        }
        
        if ($issue->project_id && $user->isAssignedToProject($issue->project_id)) {
            return $user->hasPermission('can_edit_issues');
        }
        
        return false;
    }

    /**
     * Check if user can view time entries
     */
    private function userCanViewTimeEntries($issue, $user)
    {
        // Same logic as viewing the issue itself
        return $this->userCanViewIssue($issue, $user);
    }

    /**
     * Check if user can view an issue (copied from IssueController for consistency)
     */
    private function userCanViewIssue($issue, $user)
    {
        if ($issue->assigned_to_user_id === $user->id || $issue->created_by_user_id === $user->id) {
            return true;
        }
        
        if ($issue->project_id && $user->isAssignedToProject($issue->project_id)) {
            return true;
        }
        
        if ($user->hasPermission('can_view_issues')) {
            return true;
        }
        
        return false;
    }

    /**
     * Check if user can delete a time entry
     */
    private function userCanDeleteTimeEntry($timeEntry, $user)
    {
        // User can delete if:
        // 1. They logged the time entry
        // 2. They have 'can_assign_issues' permission
        
        if ($timeEntry->user_id === $user->id) {
            return true;
        }
        
        return $user->hasPermission('can_assign_issues');
    }
}
