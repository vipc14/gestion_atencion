<?php

namespace App\Http\Controllers;

use App\Models\CustomerRecord;
use App\Http\Requests\StoreCustomerRecordRequest;
use App\Http\Requests\UpdateCustomerRecordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

// Importaciones de Modelos
use App\Models\State;
use App\Models\AttentionChannel;
use App\Models\ContactReason;
use App\Models\LineType;
use App\Models\SubscriptionPlan;
use App\Models\ReasonDetail;

class CustomerRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Cargar las relaciones necesarias para la vista
        $query = CustomerRecord::query()->with([
            'attentionChannel', 
            'contactReason', 
            'reasonDetail',
            'attentionExecutive'
        ]);

        // Si el usuario es un agente, filtramos por su ID de ejecutivo
        if ($user->hasRole('usuario de acceso') && $user->attention_executive_id) {
            $query->where('attention_executive_id', $user->attention_executive_id);
        }

        // Lógica de búsqueda
        if ($request->has('search') && $request->search != '') {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('nombre_titular', 'like', $searchTerm)
                  ->orWhere('apellido_titular', 'like', $searchTerm)
                  ->orWhere('cedula_rif', 'like', $searchTerm)
                  ->orWhere('numero_contrato', 'like', $searchTerm);
            });
        }

        $records = $query->latest()->paginate(15)->withQueryString();
        
        return view('records.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Cargar todos los datos de los catálogos para los menús desplegables
        $states = State::orderBy('name')->get();
        $channels = AttentionChannel::all();
        $reasons = ContactReason::all();
        $lineTypes = LineType::all();
        $subscriptionPlans = SubscriptionPlan::all();
        
        $user = Auth::user();
        $executive = null;
        $agentChannelName = null; // Variable para guardar el nombre del canal del agente

        // Si el usuario es un agente, obtenemos su información de atención
        if ($user->hasRole('usuario de acceso') && $user->attentionExecutive) {
            // Cargar las relaciones anidadas para tener el canal, la cola y el nombre del ejecutivo
            $executive = $user->attentionExecutive->load('attentionQueue.attentionChannel');
            if($executive->attentionQueue && $executive->attentionQueue->attentionChannel) {
                $agentChannelName = $executive->attentionQueue->attentionChannel->name;
            }
        }

        return view('records.create', compact(
            'states', 
            'channels', 
            'reasons', 
            'lineTypes', 
            'subscriptionPlans', 
            'executive',
            'agentChannelName' // Pasamos el nombre del canal a la vista
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRecordRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $record = CustomerRecord::create($request->validated());

                $reason = ContactReason::find($request->contact_reason_id);
                $detail = ReasonDetail::find($request->reason_detail_id);

                if ($reason->name === 'Pagos' && $detail->name === 'Pago con Tarjeta de Debito') {
                    $record->payment()->create([
                        'subscription_plan_id' => $request->payment_subscription_plan_id,
                        'cedula_depositante' => $request->payment_cedula_depositante,
                        'telefono_contacto' => $request->payment_telefono_contacto,
                        'id_transaccion' => $request->payment_id_transaccion,
                        'total_pagar' => $request->payment_total_pagar,
                        'email' => $request->payment_email,
                        'recibido_por_pto' => $request->payment_recibido_por_pto,
                        'metodo_pago' => $request->payment_metodo_pago,
                        'numero_aprobacion' => $request->payment_numero_aprobacion,
                    ]);
                } elseif ($reason->name === 'Pagos' && $detail->name === 'Recarga Prepago') {
                    $record->recharge()->create([
                        'numero_confirmacion_payall' => $request->recharge_numero_confirmacion_payall,
                        'numero_punto_venta' => $request->recharge_numero_punto_venta,
                        'total_recargar' => $request->recharge_total_recargar,
                        'recibido_por_pto' => $request->recharge_recibido_por_pto,
                        'metodo_pago' => $request->recharge_metodo_pago,
                        'numero_aprobacion' => $request->recharge_numero_aprobacion,
                    ]);
                } elseif ($reason->name === 'Ventas') {
                    $ivaRate = 0.16;
                    $subtotal = $detail->costo_usim + $detail->gastos_admin + $detail->costo_contrato + $detail->activacion_linea;
                    $iva = $subtotal * $ivaRate;
                    $total = $subtotal + $iva;

                    $record->invoice()->create([
                        'serial_usim' => $request->invoice_serial_usim,
                        'item_id' => $request->invoice_item_id,
                        'recibido_por_pto' => $request->invoice_recibido_por_pto,
                        'metodo_pago' => $request->invoice_metodo_pago,
                        'numero_aprobacion' => $request->invoice_numero_aprobacion,
                        'subtotal' => $subtotal,
                        'iva' => $iva,
                        'total_pagar' => $total,
                    ]);
                }
            });
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['db_error' => 'Error al guardar el registro: ' . $e->getMessage()]);
        }

        return redirect()->route('registros.index')->with('success', 'Registro creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomerRecord $registro)
    {
        $registro->load([
            'state', 'city', 'municipality', 'parish',
            'lineType', 'clientType', 'segment',
            'attentionChannel', 'attentionQueue', 'attentionExecutive',
            'contactReason', 'reasonDetail',
            'payment.subscriptionPlan', 'recharge', 'invoice'
        ]);
        return view('records.show', compact('registro'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomerRecord $registro)
    {
        $states = State::orderBy('name')->get();
        $channels = AttentionChannel::all();
        $reasons = ContactReason::all();
        $lineTypes = LineType::all();
        $subscriptionPlans = SubscriptionPlan::all();
        return view('records.edit', compact('registro', 'states', 'channels', 'reasons', 'lineTypes', 'subscriptionPlans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRecordRequest $request, CustomerRecord $registro)
    {
        try {
            DB::transaction(function () use ($request, $registro) {
                $registro->update($request->validated());
                $registro->payment()->delete();
                $registro->recharge()->delete();
                $registro->invoice()->delete();
                
                $reason = ContactReason::find($request->contact_reason_id);
                $detail = ReasonDetail::find($request->reason_detail_id);

                if ($reason->name === 'Pagos' && $detail->name === 'Pago con Tarjeta de Debito') {
                    $registro->payment()->create([
                        'subscription_plan_id' => $request->payment_subscription_plan_id,
                        'cedula_depositante' => $request->payment_cedula_depositante,
                        'telefono_contacto' => $request->payment_telefono_contacto,
                        'id_transaccion' => $request->payment_id_transaccion,
                        'total_pagar' => $request->payment_total_pagar,
                        'email' => $request->payment_email,
                        'recibido_por_pto' => $request->payment_recibido_por_pto,
                        'metodo_pago' => $request->payment_metodo_pago,
                        'numero_aprobacion' => $request->payment_numero_aprobacion,
                    ]);
                } elseif ($reason->name === 'Pagos' && $detail->name === 'Recarga Prepago') {
                    $registro->recharge()->create([
                        'numero_confirmacion_payall' => $request->recharge_numero_confirmacion_payall,
                        'numero_punto_venta' => $request->recharge_numero_punto_venta,
                        'total_recargar' => $request->recharge_total_recargar,
                        'recibido_por_pto' => $request->recharge_recibido_por_pto,
                        'metodo_pago' => $request->recharge_metodo_pago,
                        'numero_aprobacion' => $request->recharge_numero_aprobacion,
                    ]);
                } elseif ($reason->name === 'Ventas') {
                    $ivaRate = 0.16;
                    $subtotal = $detail->costo_usim + $detail->gastos_admin + $detail->costo_contrato + $detail->activacion_linea;
                    $iva = $subtotal * $ivaRate;
                    $total = $subtotal + $iva;

                    $registro->invoice()->create([
                        'serial_usim' => $request->invoice_serial_usim,
                        'item_id' => $request->invoice_item_id,
                        'recibido_por_pto' => $request->invoice_recibido_por_pto,
                        'metodo_pago' => $request->invoice_metodo_pago,
                        'numero_aprobacion' => $request->invoice_numero_aprobacion,
                        'subtotal' => $subtotal,
                        'iva' => $iva,
                        'total_pagar' => $total,
                    ]);
                }
            });
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['db_error' => 'Error al actualizar el registro: ' . $e->getMessage()]);
        }

        return redirect()->route('registros.index')->with('success', 'Registro actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomerRecord $registro)
    {
        $registro->delete();
        return redirect()->route('registros.index')->with('success', 'Registro eliminado exitosamente.');
    }
}
