<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'zip',
        'country',
        'company_id',
        'status',
        'notes',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get all offers for this customer
     */
    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    /**
     * Get active offers for this customer
     */
    public function activeOffers()
    {
        return $this->hasMany(Offer::class)->whereIn('status', ['draft', 'sent', 'accepted']);
    }

    /**
     * Check if customer is active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Get all projects for this customer
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
