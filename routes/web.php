<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerRecordController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\FailureReportController; // <-- Importar el nuevo controlador
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AlertController; // Añade esto al inicio del archivo


// --- RUTA PÚBLICA PRINCIPAL ---
Route::get('/', function () {
    return redirect()->route('login');
});

// --- RUTAS DEL DASHBOARD (PROTEGIDAS POR AUTENTICACIÓN) ---
Route::get('/dashboard', function () {
    return redirect()->route('registros.index');
})->middleware(['auth', 'verified'])->name('dashboard');


// --- RUTAS DE LA APLICACIÓN (PROTEGIDAS POR AUTENTICACIÓN) ---
Route::middleware('auth')->group(function () {
    // Perfil de Usuario (de Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- GESTIÓN DE REGISTROS ---
    Route::resource('registros', CustomerRecordController::class);

    // --- REPORTES ---
    Route::get('/reportes', [ReportController::class, 'index'])
        ->name('reports.index')
        ->middleware('role:administrador|supervisor');

    // --- NUEVA RUTA PARA REPORTE DE FALLAS ---
    Route::get('/reportes/fallas', [FailureReportController::class, 'index'])
        ->name('reports.failures')
        ->middleware('role:administrador|supervisor');

// --- NUEVA RUTA PARA ALERTAS -
    Route::get('/alertas', [AlertController::class, 'index'])
        ->name('alerts.index')
        ->middleware('role:administrador|supervisor'); // <-- AÑADE ESTA LÍNEA  

// --- NUEVA RUTA reclamos --
    Route::get('/reportes/reclamos', [ReportController::class, 'claimsIndex'])
        ->name('reports.claims')
        ->middleware('role:administrador|supervisor'); // <-- AÑADE ESTA LÍNEA

    // --- GESTIÓN DE USUARIOS ---
    Route::resource('usuarios', UserController::class)
        ->middleware('role:administrador')
        ->except(['show']);
});


// --- RUTAS DE AUTENTICACIÓN (GENERADAS POR BREEZE) ---
require __DIR__.'/auth.php';