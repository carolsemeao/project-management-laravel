<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $table = 'status';

    protected $fillable = [
        'name',
    ];

    /**
     * Get all issues with this status
     */
    public function issues()
    {
        return $this->hasMany(Issue::class);
    }
}
