<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTeam extends Model
{
    use HasFactory;

    protected $table = 'project_team';

    protected $fillable = [
        'project_id',
        'team_id',
        'status',
        'assigned_at',
        'removed_at',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'removed_at' => 'datetime',
    ];

    /**
     * Get the project
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the team
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Check if assignment is active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }
}
