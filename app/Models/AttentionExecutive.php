<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttentionExecutive extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * Usando $guarded, permitimos que todos los campos excepto el ID se rellenen masivamente.
     */
    protected $guarded = ['id'];

    /**
     * Get the attention queue that the executive belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function attentionQueue(): BelongsTo
    {
        return $this->belongsTo(AttentionQueue::class);
    }
}
