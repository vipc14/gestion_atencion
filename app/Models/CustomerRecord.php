<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CustomerRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'resultado', 'prefijo', 'contacto', 'fecha_atencion', 'numero_contrato',
        'prefijo_linea', 'numero_linea', 'tecnologia', 'nombre_titular',
        'apellido_titular', 'nacionalidad', 'cedula_rif', 'fecha_nacimiento',
        'genero', 'atencion_preferencial', 'posee_discapacidad', 'adulto_mayor',
        'detalle_requerimiento', 'es_titular', 'aprueba_id', 'dispone_saldo',
        'numero_sim', 'email', 'observaciones', 'escalado', 'estatus',
        'telefono_contacto_adicional', 'estado_id', 'ciudad_id', 'municipio_id',
        'parroquia_id', 'tipo_direccion', 'direccion', 'punto_referencia',
        'attention_channel_id', 'attention_queue_id', 'attention_executive_id',
        'line_type_id', 'client_type_id', 'segment_id',
        'contact_reason_id', 'reason_detail_id',
    ];

    protected $casts = [
        'fecha_atencion' => 'date',
        'fecha_nacimiento' => 'date',
        'atencion_preferencial' => 'boolean',
        'posee_discapacidad' => 'boolean',
        'adulto_mayor' => 'boolean',
        'es_titular' => 'boolean',
        'aprueba_id' => 'boolean',
        'dispone_saldo' => 'boolean',
        'escalado' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (CustomerRecord $record) {
            if ($record->fecha_nacimiento) {
                $record->adulto_mayor = Carbon::parse($record->fecha_nacimiento)->age >= 60;
            }
        });
    }

    // --- RELACIONES HIJAS ---
    public function payment(): HasOne { return $this->hasOne(Payment::class); }
    public function invoice(): HasOne { return $this->hasOne(Invoice::class); }
    public function recharge(): HasOne { return $this->hasOne(Recharge::class); }

    // --- RELACIONES PADRE ---
    public function state(): BelongsTo { return $this->belongsTo(State::class, 'estado_id'); }
    public function city(): BelongsTo { return $this->belongsTo(City::class, 'ciudad_id'); }
    public function municipality(): BelongsTo { return $this->belongsTo(Municipality::class, 'municipio_id'); }
    public function parish(): BelongsTo { return $this->belongsTo(Parish::class, 'parroquia_id'); }
    public function attentionChannel(): BelongsTo { return $this->belongsTo(AttentionChannel::class, 'attention_channel_id'); }
    public function attentionQueue(): BelongsTo { return $this->belongsTo(AttentionQueue::class, 'attention_queue_id'); }
    public function attentionExecutive(): BelongsTo { return $this->belongsTo(AttentionExecutive::class, 'attention_executive_id'); }
    public function contactReason(): BelongsTo { return $this->belongsTo(ContactReason::class, 'contact_reason_id'); }
    public function reasonDetail(): BelongsTo { return $this->belongsTo(ReasonDetail::class, 'reason_detail_id'); }
    public function lineType(): BelongsTo { return $this->belongsTo(LineType::class); }
    public function clientType(): BelongsTo { return $this->belongsTo(ClientType::class); }
    public function segment(): BelongsTo { return $this->belongsTo(Segment::class); }

    // --- ACCESORS ---
    public function getNombreCompletoAttribute(): string { return $this->nombre_titular . ' ' . $this->apellido_titular; }
    public function getCedulaCompletaAttribute(): string { return $this->nacionalidad . '-' . $this->cedula_rif; }
}
