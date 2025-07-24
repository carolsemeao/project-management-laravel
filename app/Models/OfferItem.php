<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferItem extends Model
{
    protected $fillable = [
        'name',
        'description',
        'hours',
        'rate_per_hour',
        'total',
        'offer_id',
        'sort_order',
    ];

    protected $casts = [
        'hours' => 'decimal:2',
        'rate_per_hour' => 'decimal:2',
        'total' => 'decimal:2',
        'sort_order' => 'integer',
    ];

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    /**
     * Calculate total automatically when hours or rate changes
     */
    public function calculateTotal()
    {
        return $this->hours * $this->rate_per_hour;
    }

    /**
     * Update total based on hours and rate
     */
    public function updateTotal()
    {
        $this->total = $this->calculateTotal();
        $this->save();
    }
}
