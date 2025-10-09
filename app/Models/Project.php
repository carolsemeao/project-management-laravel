<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        // Automatically assign creator as Project Manager when project is created
        static::created(function ($project) {
            $projectManagerRole = Role::where('name', 'Project Manager')->first();
            if ($projectManagerRole && $project->created_by_user_id) {
                ProjectUser::create([
                    'project_id' => $project->id,
                    'user_id' => $project->created_by_user_id,
                    'role_id' => $projectManagerRole->id,
                    'assigned_at' => now(),
                ]);
            }
        });
    }

    protected $fillable = [
        'name',
        'description',
        'due_date',
        'start_date',
        'status_id',
        'priority_id',
        'color',
        'budget',
        'company_id',
        'customer_id',
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
     * Get the status of this project
     */
    public function status()
    {
        return $this->belongsTo(ProjectStatus::class, 'status_id');
    }

    public function getFormattedStatusName()
    {
        return  Str::title(str_replace('_', ' ', $this->status->name));
    }

    /**
     * Get the priority of this project
     */
    public function priority()
    {
        return $this->belongsTo(ProjectPriority::class, 'priority_id');
    }

    public function getFormattedPriorityName()
    {
        return  Str::title(str_replace('_', ' ', $this->priority->name));
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
        $closedStatusId = Status::where('name', 'closed')->value('id');
        return $this->hasMany(Issue::class, 'project_id')
                   ->where('status_id', '!=', $closedStatusId);
    }


    /**
     * Get all users assigned to this project
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user')
                    ->withPivot(['role_id', 'assigned_at', 'removed_at'])
                    ->withTimestamps()
                    ->wherePivotNull('removed_at');
    }

    /**
     * Get all project-user assignments (including inactive)
     */
    public function userAssignments()
    {
        return $this->hasMany(ProjectUser::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    /**
     * Get the customer (contact person) for this project
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Get available customers for this project (filtered by company)
     */
    public function getAvailableCustomers()
    {
        if (!$this->company_id) {
            return collect();
        }
        
        return Customer::where('company_id', $this->company_id)
                      ->where('status', 'active')
                      ->orderBy('name')
                      ->get();
    }

    /**
     * Get project progress percentage (based on closed issues)
     */
    public function getProgressPercentage()
    {
        $totalIssues = $this->issues()->count();
        if ($totalIssues === 0) return 0;
        
        $closedStatusId = Status::where('name', 'closed')->value('id');
        $closedIssues = $this->issues()->where('status_id', '=', $closedStatusId)->count();
        return round(($closedIssues / $totalIssues) * 100);
    }

    /**
     * Get issues count by status
     */
    public function getIssuesByStatus($status)
    {
        return $this->issues()->where('status_id', $status)->count();
    }

    public function getOpenIssuesCount()
    {
        return $this->issues()->where('status_id', '!=', 6)->count();
    }

    /**
     * Check if project is overdue
     */
    public function isOverdue()
    {
        return $this->due_date && $this->due_date->isPast() && $this->status->name !== 'completed';
    }

    /**
     * Check if project is due soon (within 7 days)
     */
    public function isDueSoon()
    {
        if (!$this->due_date || $this->status->name === 'completed') return false;
        
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
     * Scope: Active projects
     */
    public function scopeActive($query)
    {
        return $query->whereHas('status', function ($q) {
            $q->where('name', '!=', 'closed');
        });
    }

    /**
     * Scope: Projects by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->whereHas('status', function ($q) use ($status) {
            $q->where('name', $status);
        });
    }

    /**
     * Scope: Projects for a specific user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->whereHas('users', function ($q) use ($userId) {
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

    public function getStatus()
    {
        return $this->status ? $this->status->display_name : 'Unknown';
    }
}
