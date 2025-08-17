<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ClientType extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Get the parent typeable model (LineType).
     */
    public function typeable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get all of the segments for the client type.
     */
    public function segments(): HasMany
    {
        return $this->hasMany(Segment::class);
    }
}
