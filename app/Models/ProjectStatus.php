<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectStatus extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Get all projects with this status
     */
    public function projects()
    {
        return $this->hasMany(Project::class, 'status_id');
    }

    /**
     * Get the display name (formatted)
     */
    public function getDisplayNameAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->name));
    }
} 