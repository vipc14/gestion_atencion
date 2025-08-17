<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LocationController; // <-- Importante importar el controlador
use App\Http\Controllers\Api\AttentionController;
use App\Http\Controllers\Api\ReasonController;
use App\Http\Controllers\Api\LineInfoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// --- RUTAS PARA UBICACIONES ---
// Asegúrate de que estas líneas estén aquí y no en web.php
Route::get('/locations/cities/{state_id}', [LocationController::class, 'getCities']);
Route::get('/locations/municipalities/{city_id}', [LocationController::class, 'getMunicipalities']);
Route::get('/locations/parishes/{municipality_id}', [LocationController::class, 'getParishes']);

Route::get('/reasons/details/{reason_id}', [ReasonController::class, 'getDetails']);


Route::get('/line-info/client-types/{line_type_id}', [LineInfoController::class, 'getClientTypes']);
Route::get('/line-info/segments/{client_type_id}', [LineInfoController::class, 'getSegments']);

Route::get('/attention/queues/{channel_id}', [AttentionController::class, 'getQueues']);
Route::get('/attention/executives/{queue_id}', [AttentionController::class, 'getExecutives']);

