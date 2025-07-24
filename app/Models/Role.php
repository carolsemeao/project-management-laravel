<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'permissions',
        'status',
    ];

    protected $casts = [
        'permissions' => 'json',
        'status' => 'string',
    ];

    /**
     * Get all users with this role
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'team_user')
                    ->withPivot(['team_id', 'status', 'joined_at', 'left_at'])
                    ->withTimestamps();
    }

    /**
     * Get all team memberships with this role
     */
    public function teamMemberships()
    {
        return $this->hasMany(TeamUser::class);
    }

    /**
     * Check if role has a specific permission
     */
    public function hasPermission($permission)
    {
        if (!$this->permissions || !is_array($this->permissions)) {
            return false;
        }
        
        return in_array($permission, $this->permissions);
    }

    /**
     * Check if role is active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Get default permissions structure
     */
    public static function getDefaultPermissions()
    {
        return [
            'can_view_issues',
            'can_create_issues',
            'can_edit_issues', 
            'can_assign_issues',
            'can_delete_issues',
            'can_manage_team',
            'can_view_reports',
        ];
    }
}
