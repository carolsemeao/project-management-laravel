<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Issue extends Model
{
    protected $fillable = [
        'issue_title',
        'issue_description',
        'status_id',
        'priority_id',
        'issue_due_date',
        'issue_accumulated_time',   // TODO: Remove this column
        'estimated_time_minutes',
        'logged_time_minutes',
        'project_id',
        'issue_assigned_to',        // TODO: Remove this column
        'assigned_to_user_id',
        'issue_created_by',         // TODO: Remove this column
        'created_by_user_id',       // New foreign key column
    ];

    /** @use HasFactory<\Database\Factories\IssueFactory> */
    use HasFactory;

    protected $casts = [
        'issue_due_date' => 'date',
        'issue_accumulated_time' => 'decimal:2',  // TODO: Remove this column
        'estimated_time_minutes' => 'integer',
        'logged_time_minutes' => 'integer',
    ];

    /**
     * Get the project this issue belongs to
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    /**
     * Get the status of this issue
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function getFormattedStatus()
    {
        return Str::title(str_replace('_', ' ', $this->status->name));
    }

    /**
     * Get the priority of this issue
     */
    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }

    /**
     * Get all time entries for this issue
     */
    public function timeEntries()
    {
        return $this->hasMany(TimeEntry::class)->orderBy('work_date', 'desc');
    }

    /**
     * Get time entries for a specific user
     */
    public function timeEntriesForUser($userId)
    {
        return $this->timeEntries()->where('user_id', $userId);
    }

    /**
     * Get total logged time in minutes
     */
    public function getTotalLoggedTimeMinutes()
    {
        return $this->timeEntries()->sum('time_minutes');
    }

    /**
     * Get formatted estimated time
     */
    public function getFormattedEstimatedTimeAttribute()
    {
        if (!$this->estimated_time_minutes) return null;
        return TimeEntry::formatMinutes($this->estimated_time_minutes);
    }

    /**
     * Get estimated time in hours
     */
    public function getEstimatedTimeHoursAttribute()
    {
        if (!$this->estimated_time_minutes) return null;
        return round($this->estimated_time_minutes / 60, 2);
    }

    /**
     * Get formatted logged time
     */
    public function getFormattedLoggedTimeAttribute()
    {
        $totalMinutes = $this->getTotalLoggedTimeMinutes();
        if (!$totalMinutes) return null;
        return TimeEntry::formatMinutes($totalMinutes);
    }

    /**
     * Get time progress percentage
     */
    public function getTimeProgressPercentage()
    {
        if (!$this->estimated_time_minutes || $this->estimated_time_minutes == 0) {
            return 0;
        }
        
        $loggedMinutes = $this->getTotalLoggedTimeMinutes();
        $percentage = ($loggedMinutes / $this->estimated_time_minutes) * 100;
        
        return min(round($percentage), 100); // Cap at 100%
    }

    /**
     * Log time for this issue
     */
    public function logTime($userId, $timeString, $description = null, $workDate = null)
    {
        $minutes = TimeEntry::parseTimeToMinutes($timeString);
        
        $timeEntry = $this->timeEntries()->create([
            'user_id' => $userId,
            'project_id' => $this->project_id,
            'time_minutes' => $minutes,
            'description' => $description,
            'work_date' => $workDate ?: now()->toDateString(),
            'logged_at' => now(),
        ]);

        // Update cached logged time
        $this->update([
            'logged_time_minutes' => $this->getTotalLoggedTimeMinutes()
        ]);

        return $timeEntry;
    }

    /**
     * Set estimated time using flexible input
     */
    public function setEstimatedTime($timeString)
    {
        $minutes = TimeEntry::parseTimeToMinutes($timeString);
        $this->update(['estimated_time_minutes' => $minutes]);
        return $this;
    }

    /**
     * Get time tracking status
     */
    public function getTimeTrackingStatus()
    {
        if (!$this->estimated_time_minutes) {
            return [
                'status' => 'no_estimate',
                'message' => 'No time estimated',
                'color' => 'secondary'
            ];
        }

        $loggedMinutes = $this->getTotalLoggedTimeMinutes();
        $percentage = $this->getTimeProgressPercentage();

        if ($loggedMinutes == 0) {
            return [
                'status' => 'not_started',
                'message' => 'Not started',
                'color' => 'info',
                'percentage' => 0
            ];
        }

        if ($percentage >= 100) {
            return [
                'status' => 'over_estimate',
                'message' => 'Over estimated time',
                'color' => 'danger',
                'percentage' => $percentage
            ];
        }

        if ($percentage >= 80) {
            return [
                'status' => 'near_completion',
                'message' => 'Near completion',
                'color' => 'warning',
                'percentage' => $percentage
            ];
        }

        return [
            'status' => 'in_progress',
            'message' => 'In progress',
            'color' => 'success',
            'percentage' => $percentage
        ];
    }

    /**
     * Get the user assigned to this issue
     */
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to_user_id');
    }

    /**
     * Get the user who created this issue
     */
    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    /**
     * Get assignment display text
     */
    public function getAssignmentDisplay()
    {
        if ($this->assignedUser) {
            return $this->assignedUser->name;
        } elseif ($this->issue_assigned_to) {
            return $this->issue_assigned_to . ' (Legacy)';
        }
        
        return 'Unassigned';
    }
}