<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'currency',
        'status',
        'valid_until',
        'company_id',
        'customer_id',
        'project_id',
        'created_by_user_id',
        'notes',
        'sent_at',
        'accepted_at',
        'rejected_at',
    ];

    protected $casts = [
        'valid_until' => 'date',
        'sent_at' => 'datetime',
        'accepted_at' => 'datetime',
        'rejected_at' => 'datetime',
        'price' => 'decimal:2',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the user who created this offer
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    /**
     * Get all items for this offer
     */
    public function items()
    {
        return $this->hasMany(OfferItem::class)->orderBy('sort_order');
    }

    /**
     * Calculate total price from all items
     */
    public function calculateTotal()
    {
        return $this->items()->sum('total');
    }

    /**
     * Check if offer is still valid
     */
    public function isValid()
    {
        return $this->valid_until ? $this->valid_until->isFuture() : true;
    }

    /**
     * Check if offer is expired
     */
    public function isExpired()
    {
        return $this->valid_until ? $this->valid_until->isPast() : false;
    }

    /**
     * Mark offer as sent
     */
    public function markAsSent()
    {
        $this->update([
            'status' => 'sent',
            'sent_at' => now(),
        ]);
    }

    /**
     * Mark offer as accepted
     */
    public function markAsAccepted()
    {
        $this->update([
            'status' => 'accepted',
            'accepted_at' => now(),
        ]);
    }

    /**
     * Mark offer as rejected
     */
    public function markAsRejected()
    {
        $this->update([
            'status' => 'rejected',
            'rejected_at' => now(),
        ]);
    }

    /**
     * Get formatted total with currency
     */
    public function getFormattedTotal()
    {
        return $this->formatCurrency($this->calculateTotal());
    }

    /**
     * Format amount with currency symbol
     */
    public function formatCurrency($amount)
    {
        $currencySymbols = [
            'CHF' => 'CHF',
            'EUR' => '€',
            'USD' => '$',
            'GBP' => '£',
        ];

        $symbol = $currencySymbols[$this->currency] ?? $this->currency;
        
        return $symbol . ' ' . number_format($amount, 2);
    }

    /**
     * Get available currencies
     */
    public static function getAvailableCurrencies()
    {
        return [
            'CHF' => 'Swiss Franc (CHF)',
            'EUR' => 'Euro (€)',
            'USD' => 'US Dollar ($)',
            'GBP' => 'British Pound (£)',
        ];
    }

    public function getTotalHours()
    {
        return $this->items()->sum('hours') . 'h';
    }
}
