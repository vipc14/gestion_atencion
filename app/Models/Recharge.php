<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recharge extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Get the customer record that owns the recharge.
     */
    public function customerRecord(): BelongsTo
    {
        return $this->belongsTo(CustomerRecord::class);
    }
}
