<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Cache for status IDs to avoid repeated database queries
     */
    private static $statusCache = [];

    /**
     * Get the ID of the closed status
     */
    private static function getClosedStatusId()
    {
        if (!isset(self::$statusCache['closed'])) {
            self::$statusCache['closed'] = Status::where('name', 'closed')->value('id');
        }
        return self::$statusCache['closed'];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get all issues assigned to this user
     */
    public function assignedIssues()
    {
        return $this->hasMany(Issue::class, 'assigned_to_user_id');
    }

    /**
     * Get all issues created by this user
     */
    public function createdIssues()
    {
        return $this->hasMany(Issue::class, 'created_by_user_id');
    }

    /**
     * Get count of open issues assigned to this user
     */
    public function openIssuesCount()
    {
        return $this->assignedIssues()->where('status_id', '!=', self::getClosedStatusId())->count();
    }

    /**
     * Get count of closed issues assigned to this user
     */
    public function closedIssuesCount()
    {
        return $this->assignedIssues()->where('status_id', '=', self::getClosedStatusId())->count();
    }

    /**
     * Get count of open issues created by this user
     */
    public function openCreatedIssuesCount()
    {
        return $this->createdIssues()->where('status_id', '!=', self::getClosedStatusId())->count();
    }

    /**
     * Get count of closed issues created by this user
     */
    public function closedCreatedIssuesCount()
    {
        return $this->createdIssues()->where('status_id', '=', self::getClosedStatusId())->count();
    }

    /**
     * Check if user has permission in specific team
     */
    public function hasPermissionInTeam($permission, $teamId)
    {
        $role = $this->getRoleInTeam($teamId);
        return $role ? $role->hasPermission($permission) : false;
    }

    /**
     * Check if user is member of a specific team
     */
    public function isMemberOfTeam($teamId)
    {
        return $this->teams()->where('teams.id', $teamId)->exists();
    }

    /**
     * Get all projects assigned directly to this user
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_user')
                    ->withPivot(['role_id', 'assigned_at', 'removed_at'])
                    ->withTimestamps()
                    ->wherePivotNull('removed_at');
    }

    /**
     * Get project assignments grouped by project with roles
     */
    public function getGroupedProjectAssignments()
    {
        return $this->hasMany(ProjectUser::class)
            ->with(['project', 'role'])
            ->get()
            ->groupBy('project_id')
            ->map(function ($assignments, $projectId) {
                $project = $assignments->first()->project;
                $roles = $assignments->pluck('role')->filter()->unique('id');

                return (object) [
                    'project' => $project,
                    'roles' => $roles,
                    'assignments' => $assignments
                ];
            });
    }

    /**
     * Get all projects (direct + through teams)
     */
    public function getAllProjects()
    {
        $directProjects = $this->projects;
        $teamProjects = collect();
        
        foreach ($this->teams as $team) {
            $teamProjects = $teamProjects->merge($team->projects);
        }
        
        return $directProjects->merge($teamProjects)->unique('id');
    }

    /**
     * Check if user is assigned to a project
     */
    public function isAssignedToProject(int $projectId)
    {
        // Check direct assignment to project
        return $this->projects()->where('projects.id', $projectId)->exists();
    }

    /**
     * Get all time entries logged by this user
     */
    public function timeEntries()
    {
        return $this->hasMany(TimeEntry::class)->orderBy('work_date', 'desc');
    }

    /**
     * Get time entries for a specific date range
     */
    public function timeEntriesInRange($startDate, $endDate)
    {
        return $this->timeEntries()->whereBetween('work_date', [$startDate, $endDate]);
    }

    /**
     * Get total logged time for a period in minutes
     */
    public function getTotalLoggedTimeMinutes($startDate = null, $endDate = null)
    {
        $query = $this->timeEntries();
        
        if ($startDate && $endDate) {
            $query->whereBetween('work_date', [$startDate, $endDate]);
        }
        
        return $query->sum('time_minutes');
    }

    /**
     * Get formatted total logged time
     */
    public function getFormattedTotalLoggedTime($startDate = null, $endDate = null)
    {
        $minutes = $this->getTotalLoggedTimeMinutes($startDate, $endDate);
        return $minutes ? TimeEntry::formatMinutes($minutes) : '0m';
    }

    /**
     * Get time entries for today
     */
    public function getTodayTimeEntries()
    {
        return $this->timeEntries()->whereDate('work_date', today());
    }

    /**
     * Get time entries for this week
     */
    public function getWeekTimeEntries()
    {
        return $this->timeEntries()->whereBetween('work_date', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    /**
     * Get time summary by project
     */
    public function getTimeByProject($startDate = null, $endDate = null)
    {
        $query = $this->timeEntries()->with('project');
        
        if ($startDate && $endDate) {
            $query->whereBetween('work_date', [$startDate, $endDate]);
        }
        
        return $query->get()
                    ->groupBy('project_id')
                    ->map(function ($entries) {
                        return [
                            'project' => $entries->first()->project,
                            'total_minutes' => $entries->sum('time_minutes'),
                            'formatted_time' => TimeEntry::formatMinutes($entries->sum('time_minutes')),
                            'entries_count' => $entries->count()
                        ];
                    });
    }

    /**
     * Get all offers created by this user
     */
    public function createdOffers()
    {
        return $this->hasMany(Offer::class, 'created_by_user_id');
    }

    /**
     * Get assigned issues sorted by priority and assignment date
     * High priority issues (immediate, urgent, high) come first,
     * then regular issues sorted by most recently updated
     */
    public function getAssignedIssuesSorted($limit = null)
    {
        $allUserIssues = $this->assignedIssues()
            ->with(['priority', 'status', 'project'])
            ->where('status_id', '!=', 6) // Exclude closed issues
            ->get();

        return $this->applySortingLogic($allUserIssues, $limit);
    }

    /**
     * Get created issues sorted by priority and creation date
     * High priority issues (immediate, urgent, high) come first,
     * then regular issues sorted by most recently created
     */
    public function getCreatedIssuesSorted($limit = null, $projectId = null)
    {
        $query = $this->createdIssues()
            ->with(['priority', 'status', 'project'])
            ->where('status_id', '!=', 6); // Exclude closed issues

        // Optionally filter by project (for IssueController compatibility)
        if ($projectId === null) {
            $query->whereNull('project_id');
        } elseif ($projectId !== 'all') {
            $query->where('project_id', $projectId);
        }

        $allUserIssues = $query->get();

        return $this->applySortingLogic($allUserIssues, $limit, 'created_at');
    }

    /**
     * Apply priority-based sorting logic to a collection of issues
     */
    private function applySortingLogic($issues, $limit = null, $fallbackSortField = 'updated_at')
    {
        // Separate high priority and regular issues
        $highPriorityIssues = $issues->filter(function ($issue) {
            $priorityName = $issue->priority ? $issue->priority->name : null;
            return in_array($priorityName, ['immediate', 'urgent', 'high']);
        })->sortBy(function ($issue) {
            // Sort high priority by priority level: immediate=1, urgent=2, high=3
            $priorityOrder = ['immediate' => 1, 'urgent' => 2, 'high' => 3];
            $priorityName = $issue->priority ? $issue->priority->name : null;
            return $priorityOrder[$priorityName] ?? 4;
        });

        $regularIssues = $issues->filter(function ($issue) {
            $priorityName = $issue->priority ? $issue->priority->name : null;
            return !in_array($priorityName, ['immediate', 'urgent', 'high']);
        })->sortByDesc($fallbackSortField); // Sort by specified field descending (newest first)

        // Combine: high priority first, then regular issues
        $sortedIssues = $highPriorityIssues->concat($regularIssues);

        return $limit ? $sortedIssues->take($limit) : $sortedIssues;
    }

    /**
     * Get recently updated active projects for this user
     * Returns projects sorted by most recently updated first
     */
    public function getRecentlyUpdatedActiveProjects($limit = null)
    {
        return $this->projects()
            ->active() // Exclude closed projects
            ->with(['status', 'priority', 'company', 'customer'])
            ->orderBy('updated_at', 'desc')
            ->when($limit, function ($query) use ($limit) {
                return $query->limit($limit);
            })
            ->get();
    }

    /**
     * Get activities performed by this user
     */
    public function activities()
    {
        return $this->hasMany(Activity::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get recent activities for this user
     */
    public function getRecentActivities($limit = 10)
    {
        //return Activity::getRecentForUser($this->id, $limit);
        return Activity::getGroupedActivitiesForUser($this->id, $limit);
    }
}
