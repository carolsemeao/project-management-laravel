<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    use HasFactory;

    protected $table = 'issue_priorities';

    protected $fillable = [
        'name',
    ];

    /**
     * Get all issues with this priority
     */
    public function issues()
    {
        return $this->hasMany(Issue::class);
    }
}
