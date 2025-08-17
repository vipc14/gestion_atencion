<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class LineType extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Get all of the client types for the line type.
     */
    public function clientTypes(): MorphMany
    {
        return $this->morphMany(ClientType::class, 'typeable');
    }
}
