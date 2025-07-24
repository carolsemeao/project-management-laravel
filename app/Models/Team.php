<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'color',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    /**
     * Get all users in this team
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'team_user')
                    ->withPivot(['role_id', 'status', 'joined_at', 'left_at'])
                    ->withTimestamps()
                    ->wherePivot('status', 'active');
    }

    /**
     * Get all team memberships (including inactive)
     */
    public function memberships()
    {
        return $this->hasMany(TeamUser::class);
    }

    /**
     * Get active team memberships
     */
    public function activeMemberships()
    {
        return $this->hasMany(TeamUser::class)->where('status', 'active');
    }

    /**
     * Get users with a specific role in this team
     */
    public function getUsersByRole($roleId)
    {
        return $this->users()->wherePivot('role_id', $roleId);
    }

    /**
     * Check if team is active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Get all issues assigned to this team
     */
    public function issues()
    {
        return $this->hasMany(Issue::class, 'team_id');
    }

    /**
     * Get open issues assigned to this team
     */
    public function openIssues()
    {
        return $this->hasMany(Issue::class, 'team_id')
                   ->where('issue_status', '!=', 'closed');
    }

    /**
     * Get issues assigned to this team by status
     */
    public function getIssuesByStatus($status)
    {
        return $this->issues()->where('issue_status', $status);
    }

    /**
     * Get team workload (count of open issues)
     */
    public function getWorkload()
    {
        return $this->openIssues()->count();
    }

    /**
     * Get team members with their current issue count
     */
    public function getMembersWithWorkload()
    {
        return $this->users()->withCount([
            'assignedIssues as open_issues_count' => function ($query) {
                $query->where('issue_status', '!=', 'closed');
            }
        ])->get();
    }

    /**
     * Get all projects assigned to this team
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_team')
                    ->withPivot(['status', 'assigned_at', 'removed_at'])
                    ->withTimestamps()
                    ->wherePivot('status', 'active');
    }

    /**
     * Get all project assignments (including inactive)
     */
    public function projectAssignments()
    {
        return $this->hasMany(ProjectTeam::class);
    }

    /**
     * Check if team is assigned to a project
     */
    public function isAssignedToProject(int $projectId)
    {
        return $this->projects()->where('projects.id', $projectId)->exists();
    }

    /**
     * Get team's project workload
     */
    public function getProjectWorkload()
    {
        return $this->projects()->withCount(['openIssues'])->get();
    }
}
