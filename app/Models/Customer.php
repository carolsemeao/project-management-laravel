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
     * Get all projects where this customer is the direct contact
     */
    public function projects()
    {
        return $this->hasMany(Project::class, 'customer_id');
    }

    /**
     * Get all projects for this customer's company
     */
    public function companyProjects()
    {
        return $this->hasMany(Project::class, 'company_id', 'company_id');
    }

    /**
     * Get all projects for this customer (both direct contact and company projects)
     */
    public function allProjects()
    {
        return Project::where(function ($query) {
            $query->where('customer_id', $this->id)
                  ->orWhere('company_id', $this->company_id);
        });
    }
}
