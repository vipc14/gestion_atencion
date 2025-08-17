<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\ContactReason;
use App\Models\ReasonDetail;
use App\Models\AttentionChannel;

class UpdateCustomerRecordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $recordId = $this->route('registro')->id;

        // --- DETERMINAR EL CONTEXTO DEL FORMULARIO ---
        $reason = ContactReason::find($this->input('contact_reason_id'));
        $detail = ReasonDetail::find($this->input('reason_detail_id'));
        $channel = AttentionChannel::find($this->input('attention_channel_id'));

        $isVirtual = $channel && $channel->name === 'Virtual';
        $isPayment = $reason && $reason->name === 'Pagos' && $detail && $detail->name === 'Pago con Tarjeta de Debito';
        $isRecharge = $reason && $reason->name === 'Pagos' && $detail && $detail->name === 'Recarga Prepago';
        $isSale = $reason && $reason->name === 'Ventas';

        return [
            // --- REGLAS BASE (SIEMPRE SE APLICAN) ---
            // Atención
            'attention_channel_id' => 'required|exists:attention_channels,id',
            'attention_queue_id' => 'required|exists:attention_queues,id',
            'attention_executive_id' => 'required|exists:attention_executives,id',
            'numero_contrato' => 'required|string|max:255', // Sin 'unique'
            'fecha_atencion' => 'required|date',

            // Titular
            'nacionalidad' => 'required|in:V,E',
            'cedula_rif' => 'required|string|max:20', // Sin 'unique'
            'nombre_titular' => 'required|string|max:255',
            'apellido_titular' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date|before_or_equal:today',
            'genero' => 'required|in:M,F',
            'email' => 'nullable|email|max:255', // Sin 'unique'
            'telefono_contacto_adicional' => 'nullable|string|max:20',

            // Línea y Contacto
            'line_type_id' => 'required|exists:line_types,id',
            'client_type_id' => 'required|exists:client_types,id',
            'segment_id' => 'required|exists:segments,id',
            'prefijo_linea' => 'required|in:416,426',
            'numero_linea' => 'required|string|digits:7',
            'tecnologia' => 'required|string|max:50',
            'numero_sim' => 'nullable|string|max:30', // Sin 'unique'

            // Requerimiento
            'contact_reason_id' => 'required|exists:contact_reasons,id',
            'reason_detail_id' => 'required|exists:reason_details,id',
            'detalle_requerimiento' => 'required|string',
            'resultado' => 'nullable|string|max:255',
            'observaciones' => 'nullable|string',

            // Ubicación
            'estado_id' => 'required|exists:states,id',
            'ciudad_id' => 'required|exists:cities,id',
            'municipio_id' => 'required|exists:municipalities,id',
            'parroquia_id' => 'required|exists:parishes,id',
            'direccion' => 'required|string|max:255',
            'punto_referencia' => 'nullable|string|max:255',

            // Estatus y Booleanos
            'estatus' => 'required|in:Abierto,Cerrado',
            'es_titular' => 'required|boolean',
            'aprueba_id' => 'required|boolean',
            'dispone_saldo' => 'required|boolean',
            'posee_discapacidad' => 'required|boolean',
            'atencion_preferencial' => 'required|boolean',
            'escalado' => 'required|boolean',

            // --- REGLAS CONDICIONALES ---
            'prefijo' => [Rule::requiredIf($isVirtual), 'nullable', 'in:416,426,414,424,412,422'],
            'contacto' => [Rule::requiredIf($isVirtual), 'nullable', 'string', 'digits:7'],
            
            'payment_subscription_plan_id' => [Rule::requiredIf($isPayment), 'nullable', 'exists:subscription_plans,id'],
            'payment_cedula_depositante' => [Rule::requiredIf($isPayment), 'nullable', 'string', 'max:20'],
            'payment_telefono_contacto' => [Rule::requiredIf($isPayment), 'nullable', 'string', 'max:20'],
            'payment_id_transaccion' => [Rule::requiredIf($isPayment), 'nullable', 'string', 'max:255'],
            'payment_total_pagar' => [Rule::requiredIf($isPayment), 'nullable', 'numeric', 'min:0'],
            'payment_email' => [Rule::requiredIf($isPayment), 'nullable', 'email', 'max:255'],
            'payment_recibido_por_pto' => [Rule::requiredIf($isPayment), 'nullable', 'string', 'max:50'],
            'payment_metodo_pago' => [Rule::requiredIf($isPayment), 'nullable', 'string', 'max:50'],
            'payment_numero_aprobacion' => [Rule::requiredIf($isPayment), 'nullable', 'string', 'max:255'],

            'recharge_numero_confirmacion_payall' => [Rule::requiredIf($isRecharge), 'nullable', 'string', 'max:255'],
            'recharge_numero_punto_venta' => [Rule::requiredIf($isRecharge), 'nullable', 'string', 'max:255'],
            'recharge_total_recargar' => [Rule::requiredIf($isRecharge), 'nullable', 'numeric', 'min:0'],
            'recharge_recibido_por_pto' => [Rule::requiredIf($isRecharge), 'nullable', 'string', 'max:50'],
            'recharge_metodo_pago' => [Rule::requiredIf($isRecharge), 'nullable', 'string', 'max:50'],
            'recharge_numero_aprobacion' => [Rule::requiredIf($isRecharge), 'nullable', 'string', 'max:255'],

            'invoice_serial_usim' => ['nullable', 'string', 'max:255'],
            'invoice_item_id' => ['nullable', 'string', 'max:255'],
            'invoice_recibido_por_pto' => [Rule::requiredIf($isSale), 'nullable', 'string', 'max:50'],
            'invoice_metodo_pago' => [Rule::requiredIf($isSale), 'nullable', 'string', 'max:50'],
            'invoice_numero_aprobacion' => [Rule::requiredIf($isSale), 'nullable', 'string', 'max:255'],
        ];
    }
}