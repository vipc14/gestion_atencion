<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Get the customer record that owns the payment.
     */
    public function customerRecord(): BelongsTo
    {
        return $this->belongsTo(CustomerRecord::class);
    }

    /**
     * Get the subscription plan for the payment.
     */
    public function subscriptionPlan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }
}
