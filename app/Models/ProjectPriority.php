<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectPriority extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Get all projects with this priority
     */
    public function projects()
    {
        return $this->hasMany(Project::class, 'priority_id');
    }

    /**
     * Get the display name (formatted)
     */
    public function getDisplayNameAttribute()
    {
        return ucfirst($this->name);
    }
} 