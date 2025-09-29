<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'description',
        'issue_id',
        'project_id',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who performed this activity
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the related issue (if any)
     */
    public function issue()
    {
        return $this->belongsTo(Issue::class);
    }

    /**
     * Get the related project (if any)
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Create a new activity log entry
     */
    public static function log($userId, $type, $description, $issueId = null, $projectId = null, $metadata = null)
    {
        return self::create([
            'user_id' => $userId,
            'type' => $type,
            'description' => $description,
            'issue_id' => $issueId,
            'project_id' => $projectId,
            'metadata' => $metadata,
        ]);
    }

    /**
     * Get activities for a specific user with recent first
     */
    public static function getRecentForUser($userId, $limit = 10)
    {
        return self::where('user_id', $userId)
                  ->with(['issue', 'project'])
                  ->orderBy('created_at', 'desc')
                  ->limit($limit)
                  ->get();
    }

    /**
     * Get human-readable time ago
     */
    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
