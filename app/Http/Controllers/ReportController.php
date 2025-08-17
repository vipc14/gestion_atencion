<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Invoice;
use App\Models\Recharge;
use App\Models\CustomerRecord;
use App\Models\ContactReason;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Muestra el reporte general de transacciones.
     */
    public function index()
    {
        // Cargar los datos con la información del registro principal para mostrar el nombre del cliente
        $payments = Payment::with('customerRecord')->latest()->get();
        $invoices = Invoice::with('customerRecord')->latest()->get();
        $recharges = Recharge::with('customerRecord')->latest()->get();

        // Calcular los totales de cada tabla
        $totalPayments = $payments->sum('total_pagar');
        $totalInvoices = $invoices->sum('total_pagar');
        $totalRecharges = $recharges->sum('total_recargar');

        // Calcular el total general
        $grandTotal = $totalPayments + $totalInvoices + $totalRecharges;

        // Pasar todos los datos a la vista
        return view('reports.index', compact(
            'payments',
            'invoices',
            'recharges',
            'totalPayments',
            'totalInvoices',
            'totalRecharges',
            'grandTotal'
        ));
    }

    /**
     * Muestra el panel de monitoreo para Reclamos.
     */
    public function claimsIndex()
    {
        $claimReason = ContactReason::where('name', 'Reclamo')->first();

        if (!$claimReason) {
            return view('reports.claims', ['claimsByDetail' => collect(), 'claimsByLocation' => collect()]);
        }

        // 1. Contamos los reclamos por cada detalle de motivo
        $claimsByDetail = CustomerRecord::where('customer_records.contact_reason_id', $claimReason->id)
            ->join('reason_details', 'customer_records.reason_detail_id', '=', 'reason_details.id')
            ->select('reason_details.name', DB::raw('count(*) as total'))
            ->groupBy('reason_details.name')
            ->orderBy('total', 'desc')
            ->take(10)
            ->get();

        // 2. Contamos los reclamos por ubicación geográfica
        $claimsByLocation = CustomerRecord::where('customer_records.contact_reason_id', $claimReason->id)
            ->join('states', 'customer_records.estado_id', '=', 'states.id')
            ->join('cities', 'customer_records.ciudad_id', '=', 'cities.id')
            ->join('municipalities', 'customer_records.municipio_id', '=', 'municipalities.id')
            ->join('parishes', 'customer_records.parroquia_id', '=', 'parishes.id')
            ->select(
                'states.name as state_name',
                'cities.name as city_name',
                'municipalities.name as municipality_name',
                'parishes.name as parish_name',
                DB::raw('count(*) as total')
            )
            ->groupBy('state_name', 'city_name', 'municipality_name', 'parish_name')
            ->orderBy('total', 'desc')
            ->take(15)
            ->get();

        return view('reports.claims', compact('claimsByDetail', 'claimsByLocation'));
    }
}
