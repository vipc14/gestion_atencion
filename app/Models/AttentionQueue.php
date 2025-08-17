<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttentionQueue extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Get the attention channel that the queue belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function attentionChannel(): BelongsTo
    {
        return $this->belongsTo(AttentionChannel::class);
    }
}
