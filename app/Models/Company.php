<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
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
        'website',
        'notes',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    /**
     * Get all customers for this company
     */
    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    /**
     * Get active customers for this company
     */
    public function activeCustomers()
    {
        return $this->hasMany(Customer::class)->where('status', 'active');
    }

    /**
     * Check if company is active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }
}
