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
        return $this->assignedIssues()->where('issue_status', '!=', 'closed')->count();
    }

    /**
     * Get all teams this user belongs to
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_user')
                    ->withPivot(['role_id', 'status', 'joined_at', 'left_at'])
                    ->withTimestamps()
                    ->wherePivot('status', 'active');
    }

    /**
     * Get all team memberships (including inactive)
     */
    public function teamMemberships()
    {
        return $this->hasMany(TeamUser::class);
    }

    /**
     * Get active team memberships
     */
    public function activeTeamMemberships()
    {
        return $this->hasMany(TeamUser::class)->where('status', 'active');
    }

    /**
     * Get user's role in a specific team
     */
    public function getRoleInTeam($teamId)
    {
        $membership = $this->teamMemberships()
                          ->where('team_id', $teamId)
                          ->where('status', 'active')
                          ->with('role')
                          ->first();
        
        return $membership ? $membership->role : null;
    }

    /**
     * Check if user has permission in any team
     */
    public function hasPermission($permission)
    {
        return $this->activeTeamMemberships()
                   ->with('role')
                   ->get()
                   ->pluck('role')
                   ->filter()
                   ->some(function ($role) use ($permission) {
                       return $role->hasPermission($permission);
                   });
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
                    ->withPivot(['role_id', 'status', 'assigned_at', 'removed_at'])
                    ->withTimestamps()
                    ->wherePivot('status', 'active');
    }

    /**
     * Get all project assignments (including inactive)
     */
    public function projectAssignments()
    {
        return $this->hasMany(ProjectUser::class);
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
        // Check direct assignment
        if ($this->projects()->where('projects.id', $projectId)->exists()) {
            return true;
        }
        
        // Check through teams
        return $this->teams()->whereHas('projects', function ($query) use ($projectId) {
            $query->where('projects.id', $projectId);
        })->exists();
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
}
