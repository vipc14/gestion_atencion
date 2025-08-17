@extends('layouts.app')

@section('title', 'Centro de Monitoreo de Fallas')

@section('content')
<div class="row mb-3">
    <div class="col-lg-12">
        <h2><i class="fas fa-tachometer-alt me-2"></i>Centro de Monitoreo de Fallas</h2>
        <p class="text-muted">Panel de control con alertas activas y análisis de incidencias recurrentes.</p>
    </div>
</div>

<!-- SECCIÓN 1: ALERTAS ACTIVAS -->
<div class="card mb-5">
    <div class="card-header fw-bold">
        <i class="fas fa-bell me-2"></i>Estado Actual del Sistema (Última Hora)
    </div>
    <div class="card-body">
        @forelse($alerts as $alert)
            <div class="alert alert-{{ $alert['level'] }} mb-3" role="alert">
                <h4 class="alert-heading">
                    @if($alert['level'] == 'danger')
                        <i class="fas fa-exclamation-triangle me-2"></i>Alerta Crítica
                    @else
                        <i class="fas fa-exclamation-circle me-2"></i>Advertencia
                    @endif
                    - {{ $alert['type'] }}
                </h4>
                <p class="mb-0">{{ $alert['message'] }}</p>
            </div>
        @empty
            <div class="alert alert-success mb-0" role="alert">
                <h4 class="alert-heading"><i class="fas fa-check-circle me-2"></i>Sistema Estable</h4>
                <p class="mb-0">No se han detectado alertas activas en la última hora. Todos los sistemas operan dentro de los parámetros normales.</p>
            </div>
        @endforelse
    </div>
    <div class="card-footer text-muted small">
        Actualizado: {{ now()->format('d/m/Y H:i:s') }}
    </div>
</div>


<!-- SECCIÓN 2: ANÁLISIS DE INCIDENCIAS -->
<div class="row">
    <!-- Columna del Termómetro de Fallas (MODIFICADA) -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-list-ol me-2"></i>Top 10 Fallas Reportadas</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @forelse($failuresByDetail as $failure)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $failure->name }}
                            <span class="badge bg-danger rounded-pill">{{ $failure->total }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-center text-muted">No hay datos de fallas operativas para mostrar.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <!-- Columna de Ubicaciones con más Fallas -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-map-marked-alt me-2"></i>Ubicaciones con Mayor Incidencia</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Ubicación (Parroquia, Municipio)</th>
                                <th class="text-end">Total de Fallas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($failuresByLocation as $location)
                                <tr>
                                    <td>
                                        {{ $location->parish_name }}, {{ $location->municipality_name }}<br>
                                        <small class="text-muted">{{ $location->city_name }}, {{ $location->state_name }}</small>
                                    </td>
                                    <td class="text-end fw-bold">{{ $location->total }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted mt-3">No hay datos de ubicación para mostrar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection