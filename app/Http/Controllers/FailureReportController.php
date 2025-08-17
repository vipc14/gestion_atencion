<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CustomerRecord;
use App\Models\ContactReason;

class FailureReportController extends Controller
{
    // --- CONSTANTES DE CONFIGURACIÓN DE ALERTAS Y REPORTES ---
    const TOTAL_USERS = 5000000;
    const YELLOW_THRESHOLD_PERCENTAGE = 0.0001; // 0.01% (500 fallas)
    const RED_THRESHOLD_PERCENTAGE = 0.001;    // 0.1%  (5000 fallas)
    const GEO_CONCENTRATION_THRESHOLD = 0.5;   // 50%
    const MIN_FAILURES_FOR_GEO_ALERT = 10;
    const MIN_FAILURES_FOR_THERMOMETER = 1;

    public function index()
    {
        $alerts = [];
        $failureReason = ContactReason::where('name', 'Falla Operativa')->first();

        if (!$failureReason) {
            return view('reports.failures', [
                'alerts' => [],
                'failuresByDetail' => collect(), 
                'failuresByLocation' => collect()
            ]);
        }

        // --- CÁLCULO DE ALERTAS (LÓGICA DEL ANTIGUO ALERTCONTROLLER) ---
        $recentFailures = CustomerRecord::where('contact_reason_id', $failureReason->id)
            ->where('created_at', '>=', now()->subHour())
            ->with('reasonDetail', 'state')
            ->get();

        $failuresGroupedByDetail = $recentFailures->groupBy('reason_detail_id');
        $yellowThreshold = self::TOTAL_USERS * self::YELLOW_THRESHOLD_PERCENTAGE;
        $redThreshold = self::TOTAL_USERS * self::RED_THRESHOLD_PERCENTAGE;

        foreach ($failuresGroupedByDetail as $detailId => $failures) {
            $failureCount = count($failures);
            $failureName = $failures->first()->reasonDetail->name;

            // Verificación de Alerta por Volumen
            if ($failureCount >= $redThreshold) {
                $alerts[] = ['level' => 'danger', 'type' => 'Volumen Crítico', 'message' => "La falla '{$failureName}' ha superado el umbral crítico con {$failureCount} reportes en la última hora."];
            } elseif ($failureCount >= $yellowThreshold) {
                $alerts[] = ['level' => 'warning', 'type' => 'Volumen Anormal', 'message' => "La falla '{$failureName}' presenta un volumen inusual con {$failureCount} reportes en la última hora."];
            }

            // Verificación de Alerta por Concentración Geográfica
            if ($failureCount >= self::MIN_FAILURES_FOR_GEO_ALERT) {
                $locations = $failures->groupBy('estado_id');
                foreach ($locations as $stateId => $locationFailures) {
                    $locationCount = count($locationFailures);
                    $concentration = $locationCount / $failureCount;
                    if ($concentration >= self::GEO_CONCENTRATION_THRESHOLD) {
                        $stateName = $locationFailures->first()->state->name;
                        $alerts[] = ['level' => 'danger', 'type' => 'Concentración Geográfica', 'message' => "El " . round($concentration * 100) . "% de las fallas '{$failureName}' se concentran en {$stateName}."];
                    }
                }
            }
        }

        // --- CÁLCULO PARA EL TERMÓMETRO Y TABLA (LÓGICA EXISTENTE) ---
        $failuresByDetail = CustomerRecord::query()
            ->where('customer_records.contact_reason_id', $failureReason->id)
            ->join('reason_details', 'customer_records.reason_detail_id', '=', 'reason_details.id')
            ->select('reason_details.name', DB::raw('count(*) as total'))
            ->groupBy('reason_details.name')
            ->having('total', '>', self::MIN_FAILURES_FOR_THERMOMETER)
            ->orderBy('total', 'desc')
            ->take(10)
            ->get();

        $failuresByLocation = CustomerRecord::query()
            ->where('customer_records.contact_reason_id', $failureReason->id)
            ->join('states', 'customer_records.estado_id', '=', 'states.id')
            ->join('cities', 'customer_records.ciudad_id', '=', 'cities.id')
            ->join('municipalities', 'customer_records.municipio_id', '=', 'municipalities.id')
            ->join('parishes', 'customer_records.parroquia_id', '=', 'parishes.id')
            ->select('states.name as state_name', 'cities.name as city_name', 'municipalities.name as municipality_name', 'parishes.name as parish_name', DB::raw('count(*) as total'))
            ->groupBy('state_name', 'city_name', 'municipality_name', 'parish_name')
            ->orderBy('total', 'desc')
            ->take(15)
            ->get();

        return view('reports.failures', compact('alerts', 'failuresByDetail', 'failuresByLocation'));
    }
}
