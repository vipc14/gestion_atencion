<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * O usamos $fillable para listar los campos permitidos,
     * o $guarded para listar los campos prohibidos (más fácil).
     * Con $guarded = ['id'], permitimos que todos los campos excepto el ID se rellenen.
     */
    protected $guarded = ['id'];

    /**
     * Get the customer record that owns the invoice.
     */
    public function customerRecord(): BelongsTo
    {
        return $this->belongsTo(CustomerRecord::class);
    }
}
