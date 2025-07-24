<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TimeEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'issue_id',
        'user_id', 
        'project_id',
        'time_minutes',
        'description',
        'work_date',
        'logged_at',
    ];

    protected $casts = [
        'work_date' => 'date',
        'logged_at' => 'datetime',
        'time_minutes' => 'integer',
    ];

    /**
     * Get the issue this time entry belongs to
     */
    public function issue()
    {
        return $this->belongsTo(Issue::class);
    }

    /**
     * Get the user who logged this time
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the project this time entry belongs to
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get formatted time display (e.g., "1h 30m", "45m", "2.5h")
     */
    public function getFormattedTimeAttribute()
    {
        return self::formatMinutes($this->time_minutes);
    }

    /**
     * Get decimal hours
     */
    public function getHoursAttribute()
    {
        return round($this->time_minutes / 60, 2);
    }

    /**
     * Static method to format minutes into readable time
     */
    public static function formatMinutes($minutes)
    {
        if ($minutes < 60) {
            return $minutes . 'm';
        }
        
        $hours = floor($minutes / 60);
        $mins = $minutes % 60;
        
        if ($mins == 0) {
            return $hours . 'h';
        }
        
        return $hours . 'h ' . $mins . 'm';
    }

    /**
     * Static method to parse various time formats into minutes
     * Supports: "1h 30m", "1.5h", "90m", "1:30", "1h30m", "1h30", "2d"
     */
    public static function parseTimeToMinutes($timeString)
    {
        $timeString = trim(strtolower($timeString));
        
        // Handle days (2d, 1d) - assume 8 hours per day
        if (preg_match('/^(\d+)d$/', $timeString, $matches)) {
            return (int) $matches[1] * 8 * 60; // days * 8 hours * 60 minutes
        }
        
        // Handle decimal hours (1.5h, 2.25h)
        if (preg_match('/^(\d*\.?\d+)h?$/', $timeString, $matches)) {
            return (int) round(floatval($matches[1]) * 60);
        }
        
        // Handle minutes only (90m, 45m)
        if (preg_match('/^(\d+)m$/', $timeString, $matches)) {
            return (int) $matches[1];
        }
        
        // Handle hours and minutes (1h 30m, 1h30m, 1h30)
        if (preg_match('/^(\d+)h\s*(\d+)m?$/', $timeString, $matches)) {
            return (int) $matches[1] * 60 + (int) $matches[2];
        }
        
        // Handle time format (1:30, 2:15)
        if (preg_match('/^(\d+):(\d+)$/', $timeString, $matches)) {
            return (int) $matches[1] * 60 + (int) $matches[2];
        }
        
        // Handle just hours (1h, 2h)
        if (preg_match('/^(\d+)h$/', $timeString, $matches)) {
            return (int) $matches[1] * 60;
        }
        
        // If no pattern matches, try to parse as numeric minutes
        if (is_numeric($timeString)) {
            return (int) $timeString;
        }
        
        throw new \InvalidArgumentException("Invalid time format: {$timeString}");
    }

    /**
     * Scope: Entries for a specific date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('work_date', [$startDate, $endDate]);
    }

    /**
     * Scope: Entries for a specific user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope: Entries for a specific project
     */
    public function scopeForProject($query, $projectId)
    {
        return $query->where('project_id', $projectId);
    }

    /**
     * Scope: Entries for today
     */
    public function scopeToday($query)
    {
        return $query->whereDate('work_date', Carbon::today());
    }

    /**
     * Scope: Entries for this week
     */
    public function scopeThisWeek($query)
    {
        return $query->whereBetween('work_date', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ]);
    }
}
