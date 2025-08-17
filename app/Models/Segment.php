<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Segment extends Model
{
    use HasFactory;

    protected $fillable = ['client_type_id', 'name'];

    public function clientType(): BelongsTo
    {
        return $this->belongsTo(ClientType::class);
    }
}
