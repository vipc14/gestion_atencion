    @extends('layouts.app')

    @section('title', 'Monitoreo de Reclamos')

    @section('content')
    <div class="row mb-3">
        <div class="col-lg-12">
            <h2><i class="fas fa-exclamation-circle me-2"></i>Centro de Monitoreo de Reclamos</h2>
            <p class="text-muted">Análisis de los reclamos más recurrentes y su ubicación geográfica.</p>
        </div>
    </div>

    <div class="row">
        <!-- Columna de Top Reclamos -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-list-ol me-2"></i>Top 10 Reclamos Reportados</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @forelse($claimsByDetail as $claim)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $claim->name }}
                                <span class="badge bg-danger rounded-pill">{{ $claim->total }}</span>
                            </li>
                        @empty
                            <li class="list-group-item text-center text-muted">No hay datos de reclamos para mostrar.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <!-- Columna de Ubicaciones con más Reclamos -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-map-marked-alt me-2"></i>Ubicaciones con Mayor Incidencia de Reclamos</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Ubicación (Parroquia, Municipio)</th>
                                    <th class="text-end">Total de Reclamos</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($claimsByLocation as $location)
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
    