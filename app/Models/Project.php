<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'due_date',
        'start_date',
        'status',
        'priority',
        'color',
        'budget',
        'created_by_user_id',
    ];

    protected $casts = [
        'due_date' => 'date',
        'start_date' => 'date',
        'budget' => 'decimal:2',
    ];

    /**
     * Get the user who created this project
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    /**
     * Get all issues in this project
     */
    public function issues()
    {
        return $this->hasMany(Issue::class, 'project_id');
    }

    /**
     * Get open issues in this project
     */
    public function openIssues()
    {
        return $this->hasMany(Issue::class, 'project_id')
                   ->where('status_id', '!=', 6);
    }

    /**
     * Get all teams assigned to this project
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'project_team')
                    ->withPivot(['status', 'assigned_at', 'removed_at'])
                    ->withTimestamps()
                    ->wherePivot('status', 'active');
    }

    /**
     * Get all users assigned to this project
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user')
                    ->withPivot(['role_id', 'status', 'assigned_at', 'removed_at'])
                    ->withTimestamps()
                    ->wherePivot('status', 'active');
    }

    /**
     * Get all project-user assignments (including inactive)
     */
    public function userAssignments()
    {
        return $this->hasMany(ProjectUser::class);
    }

    /**
     * Get project progress percentage (based on closed issues)
     */
    public function getProgressPercentage()
    {
        $totalIssues = $this->issues()->count();
        if ($totalIssues === 0) return 0;
        
        $closedIssues = $this->issues()->where('status_id', '=', 6)->count();
        return round(($closedIssues / $totalIssues) * 100);
    }

    /**
     * Get issues count by status
     */
    public function getIssuesByStatus($status)
    {
        return $this->issues()->where('status_id', $status)->count();
    }

    /**
     * Check if project is overdue
     */
    public function isOverdue()
    {
        return $this->due_date && $this->due_date->isPast() && $this->status !== 'completed';
    }

    /**
     * Check if project is due soon (within 7 days)
     */
    public function isDueSoon()
    {
        if (!$this->due_date || $this->status === 'completed') return false;
        
        $daysUntilDue = Carbon::now()->diffInDays($this->due_date, false);
        return $daysUntilDue >= 0 && $daysUntilDue <= 7;
    }

    /**
     * Get project duration in days
     */
    public function getDurationInDays()
    {
        if (!$this->start_date || !$this->due_date) return null;
        
        return $this->start_date->diffInDays($this->due_date);
    }

    /**
     * Check if user is assigned to this project
     */
    public function hasUser(int $userId)
    {
        return $this->users()->where('users.id', $userId)->exists();
    }

    /**
     * Assign user to project with role
     */
    public function assignUser(int $userId, ?int $roleId = null)
    {
        if (!$this->hasUser($userId)) {
            $this->users()->attach($userId, [
                'role_id' => $roleId,
                'status' => 'active',
                'assigned_at' => now(),
            ]);
        }
    }

    /**
     * Assign a team to this project
     */
    public function assignTeam(int $teamId)
    {
        $this->teams()->attach($teamId, [
            'status' => 'active',
            'assigned_at' => now(),
        ]);
    }

    /**
     * Get all users (direct + through teams)
     */
    public function getAllUsers()
    {
        $directUsers = $this->users;
        $teamUsers = collect();
        
        foreach ($this->teams as $team) {
            $teamUsers = $teamUsers->merge($team->users);
        }
        
        return $directUsers->merge($teamUsers)->unique('id');
    }

    /**
     * Scope: Active projects
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope: Projects by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope: Projects for a specific user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->whereHas('users', function ($q) use ($userId) {
            $q->where('users.id', $userId);
        })->orWhereHas('teams.users', function ($q) use ($userId) {
            $q->where('users.id', $userId);
        });
    }

    /**
     * Get all time entries for this project
     */
    public function timeEntries()
    {
        return $this->hasMany(TimeEntry::class)->orderBy('work_date', 'desc');
    }

    /**
     * Get total logged time for this project in minutes
     */
    public function getTotalLoggedTimeMinutes()
    {
        return $this->timeEntries()->sum('time_minutes');
    }

    /**
     * Get formatted total logged time
     */
    public function getFormattedTotalLoggedTime()
    {
        $minutes = $this->getTotalLoggedTimeMinutes();
        return $minutes ? TimeEntry::formatMinutes($minutes) : '0m';
    }

    /**
     * Get total estimated time for all issues in minutes
     */
    public function getTotalEstimatedTimeMinutes()
    {
        return $this->issues()->sum('estimated_time_minutes');
    }

    /**
     * Get formatted total estimated time
     */
    public function getFormattedTotalEstimatedTime()
    {
        $minutes = $this->getTotalEstimatedTimeMinutes();
        return $minutes ? TimeEntry::formatMinutes($minutes) : '0m';
    }

    /**
     * Get time tracking progress for the project
     */
    public function getTimeTrackingProgress()
    {
        $estimatedMinutes = $this->getTotalEstimatedTimeMinutes();
        $loggedMinutes = $this->getTotalLoggedTimeMinutes();

        if (!$estimatedMinutes) {
            return [
                'percentage' => 0,
                'status' => 'no_estimate',
                'estimated' => '0m',
                'logged' => TimeEntry::formatMinutes($loggedMinutes),
                'remaining' => 'Unknown'
            ];
        }

        $percentage = min(round(($loggedMinutes / $estimatedMinutes) * 100), 100);
        $remaining = max($estimatedMinutes - $loggedMinutes, 0);

        return [
            'percentage' => $percentage,
            'status' => $percentage >= 100 ? 'over_estimate' : ($percentage >= 80 ? 'near_completion' : 'in_progress'),
            'estimated' => TimeEntry::formatMinutes($estimatedMinutes),
            'logged' => TimeEntry::formatMinutes($loggedMinutes),
            'remaining' => TimeEntry::formatMinutes($remaining)
        ];
    }

    /**
     * Get time entries by user
     */
    public function getTimeByUser()
    {
        return $this->timeEntries()
                   ->with('user')
                   ->get()
                   ->groupBy('user_id')
                   ->map(function ($entries) {
                       return [
                           'user' => $entries->first()->user,
                           'total_minutes' => $entries->sum('time_minutes'),
                           'formatted_time' => TimeEntry::formatMinutes($entries->sum('time_minutes')),
                           'entries_count' => $entries->count()
                       ];
                   });
    }

    /**
     * Get time entries for a specific date range
     */
    public function getTimeInRange($startDate, $endDate)
    {
        return $this->timeEntries()->whereBetween('work_date', [$startDate, $endDate]);
    }

    /**
     * Get daily time breakdown for charts
     */
    public function getDailyTimeBreakdown($days = 30)
    {
        $startDate = now()->subDays($days);
        $endDate = now();

        return $this->timeEntries()
                   ->selectRaw('DATE(work_date) as date, SUM(time_minutes) as total_minutes')
                   ->whereBetween('work_date', [$startDate, $endDate])
                   ->groupBy('date')
                   ->orderBy('date')
                   ->get()
                   ->mapWithKeys(function ($item) {
                       return [$item->date => [
                           'minutes' => $item->total_minutes,
                           'formatted' => TimeEntry::formatMinutes($item->total_minutes)
                       ]];
                   });
    }

    /**
     * Get all offers for this project
     */
    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    /**
     * Get active offers for this project
     */
    public function activeOffers()
    {
        return $this->hasMany(Offer::class)->whereIn('status', ['draft', 'sent', 'accepted']);
    }

    /**
     * Get total hours from all offers for this project
     */
    public function getTotalOfferHours()
    {
        return ceil($this->offers()
                   ->with('items')
                   ->get()
                   ->sum(function ($offer) {
                       return $offer->items->sum('hours');
                   }));
    }

    /**
     * Get formatted total offer hours
     */
    public function getFormattedTotalOfferHours()
    {
        $hours = $this->getTotalOfferHours();
        return $hours ? ceil($hours) . 'h' : '0h';
    }

    /**
     * Get total estimated hours (issues + offers) rounded up
     */
    public function getTotalEstimatedHours()
    {
        $issueHours = $this->getTotalEstimatedTimeMinutes() / 60; // Convert minutes to hours
        $offerHours = $this->getTotalOfferHours();
        
        return ceil($issueHours + $offerHours); // Round up to nearest whole number
    }

    /**
     * Get combined time progress (issues + offers)
     */
    public function getCombinedTimeProgress()
    {
        // Get time from issues
        $issueTimeProgress = $this->getTimeTrackingProgress();
        $issueEstimatedMinutes = $this->getTotalEstimatedTimeMinutes();
        $issueLoggedMinutes = $this->getTotalLoggedTimeMinutes();

        // Get time from offers (all offer hours count as "estimated")
        $offerHours = $this->getTotalOfferHours();
        $offerEstimatedMinutes = $offerHours * 60; // Convert hours to minutes

        // Calculate totals
        $totalEstimatedMinutes = $issueEstimatedMinutes + $offerEstimatedMinutes;
        $totalLoggedMinutes = $issueLoggedMinutes; // Only issues have logged time

        if ($totalEstimatedMinutes == 0) {
            return [
                'percentage' => 0,
                'status' => 'no_estimate',
                'total_estimated' => '0h',
                'total_logged' => '0h',
                'issue_estimated' => TimeEntry::formatMinutes($issueEstimatedMinutes),
                'issue_logged' => TimeEntry::formatMinutes($issueLoggedMinutes),
                'offer_hours' => $this->getFormattedTotalOfferHours(),
                'remaining' => 'Unknown'
            ];
        }

        $percentage = min(round(($totalLoggedMinutes / $totalEstimatedMinutes) * 100), 100);
        $remainingMinutes = max($totalEstimatedMinutes - $totalLoggedMinutes, 0);

        return [
            'percentage' => $percentage,
            'status' => $percentage >= 100 ? 'completed' : ($percentage >= 80 ? 'near_completion' : 'in_progress'),
            'total_estimated' => TimeEntry::formatMinutes($totalEstimatedMinutes),
            'total_logged' => TimeEntry::formatMinutes($totalLoggedMinutes),
            'issue_estimated' => TimeEntry::formatMinutes($issueEstimatedMinutes),
            'issue_logged' => TimeEntry::formatMinutes($issueLoggedMinutes),
            'offer_hours' => $this->getFormattedTotalOfferHours(),
            'remaining' => TimeEntry::formatMinutes($remainingMinutes)
        ];
    }
}
