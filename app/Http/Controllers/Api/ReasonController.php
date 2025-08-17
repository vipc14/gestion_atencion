<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ReasonDetail;
use Illuminate\Http\Request;

class ReasonController extends Controller
{
    /**
     * Fetch the details for a given contact reason ID.
     *
     * @param  int  $reason_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDetails($reason_id)
    {
        // Busca todos los detalles que pertenecen al motivo de contacto proporcionado.
        // El método get() recuperará todas las columnas, incluyendo los costos
        // que añadimos para los detalles de "Ventas".
        $details = ReasonDetail::where('contact_reason_id', $reason_id)
                               ->orderBy('name')
                               ->get();

        // Devuelve los resultados en formato JSON para que el JavaScript los pueda procesar.
        return response()->json($details);
    }
}
