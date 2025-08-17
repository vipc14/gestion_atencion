@extends('layouts.app')

@section('title', 'Detalle del Registro')

@section('content')
<div class="row mb-4">
    <div class="col-lg-12 d-flex justify-content-between align-items-center">
        <h2>Detalle del Registro #{{ $registro->id }}</h2>
        <a class="btn btn-primary" href="{{ route('registros.index') }}"> <i class="fas fa-arrow-left"></i> Volver al Listado</a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <strong>Nº Contrato:</strong> {{ $registro->numero_contrato }}
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Columna de Datos del Titular -->
            <div class="col-md-6 mb-4">
                <h5 class="border-bottom pb-2 mb-3">Datos del Titular</h5>
                <p><strong>Nombre Completo:</strong> {{ $registro->nombre_completo }}</p>
                <p><strong>Cédula/RIF:</strong> {{ $registro->cedula_completa }}</p>
                <p><strong>Fecha de Nacimiento:</strong> {{ $registro->fecha_nacimiento->format('d/m/Y') }} ({{ $registro->fecha_nacimiento->age }} años)</p>
                <p><strong>Género:</strong> {{ $registro->genero == 'M' ? 'Masculino' : 'Femenino' }}</p>
                <p><strong>Email:</strong> {{ $registro->email ?? 'N/A' }}</p>
                <p><strong>Teléfono Alternativo:</strong> {{ $registro->telefono_contacto_adicional ?? 'N/A' }}</p>
                <p><strong>Adulto Mayor:</strong> <span class="badge bg-{{ $registro->adulto_mayor ? 'success' : 'secondary' }}">{{ $registro->adulto_mayor ? 'Sí' : 'No' }}</span></p>
                <p><strong>Atención Preferencial:</strong> <span class="badge bg-{{ $registro->atencion_preferencial ? 'success' : 'secondary' }}">{{ $registro->atencion_preferencial ? 'Sí' : 'No' }}</span></p>
                <p><strong>Posee Discapacidad:</strong> <span class="badge bg-{{ $registro->posee_discapacidad ? 'success' : 'secondary' }}">{{ $registro->posee_discapacidad ? 'Sí' : 'No' }}</span></p>
            </div>

            <!-- Columna de Datos de la Línea y Atención -->
            <div class="col-md-6 mb-4">
                <h5 class="border-bottom pb-2 mb-3">Datos de la Línea y Atención</h5>
                <p><strong>Nº a Gestionar:</strong> {{ $registro->prefijo_linea }}{{ $registro->numero_linea }}</p>
                <p><strong>Tipo de Línea:</strong> {{ $registro->lineType?->name ?? 'N/A' }}</p>
                <p><strong>Tipo de Cliente:</strong> {{ $registro->clientType?->name ?? 'N/A' }}</p>
                <p><strong>Segmento:</strong> {{ $registro->segment?->name ?? 'N/A' }}</p>
                <p><strong>Tecnología:</strong> {{ $registro->tecnologia }}</p>
                <hr>
                <p><strong>Fecha de Atención:</strong> {{ $registro->fecha_atencion->format('d/m/Y') }}</p>
                <p><strong>Canal:</strong> {{ $registro->attentionChannel?->name ?? 'N/A' }}</p>
                <p><strong>Cola:</strong> {{ $registro->attentionQueue?->name ?? 'N/A' }}</p>
                <p><strong>Ejecutivo:</strong> {{ $registro->attentionExecutive?->name ?? 'N/A' }}</p>
                <p><strong>Estatus:</strong> <span class="badge {{ $registro->estatus == 'Abierto' ? 'bg-warning text-dark' : 'bg-success' }}">{{ $registro->estatus }}</span></p>
            </div>
        </div>

        <!-- Sección de Detalles del Requerimiento -->
        <h5 class="border-bottom pb-2 mb-3">Detalles del Requerimiento</h5>
        <p><strong>Motivo:</strong> {{ $registro->contactReason?->name ?? 'N/A' }} - {{ $registro->reasonDetail?->name ?? 'N/A' }}</p>
        <p><strong>Observaciones del Requerimiento:</strong></p>
        <p class="ms-3">{{ $registro->detalle_requerimiento }}</p>
        
        
        <!-- Aquí irían las secciones condicionales si existen datos de pago, recarga o factura -->
        @if($registro->payment)
            <h5 class="border-bottom pb-2 mt-4 mb-3">Información del Pago</h5>
            <div class="row">
                <div class="col-md-4"><p><strong>Plan:</strong> {{ $registro->payment->subscriptionPlan?->name ?? 'N/A' }}</p></div>
                <div class="col-md-4"><p><strong>Total Pagado:</strong> {{ $registro->payment->total_pagar }}</p></div>
                <div class="col-md-4"><p><strong>Nº Aprobación:</strong> {{ $registro->payment->numero_aprobacion }}</p></div>
            </div>
        @endif
        
        @if($registro->recharge)
            <h5 class="border-bottom pb-2 mt-4 mb-3">Información de la Recarga</h5>
            <div class="row">
                <div class="col-md-4"><p><strong>Total Recargado:</strong> {{ $registro->recharge->total_recargar }}</p></div>
                <div class="col-md-4"><p><strong>Confirmación PAYALL:</strong> {{ $registro->recharge->numero_confirmacion_payall }}</p></div>
                <div class="col-md-4"><p><strong>Nº Aprobación:</strong> {{ $registro->recharge->numero_aprobacion }}</p></div>
            </div>
        @endif

        @if($registro->invoice)
            <h5 class="border-bottom pb-2 mt-4 mb-3">Información de la Factura</h5>
             <div class="row">
                <div class="col-md-4"><p><strong>Subtotal:</strong> {{ $registro->invoice->subtotal }}</p></div>
                <div class="col-md-4"><p><strong>IVA (16%):</strong> {{ $registro->invoice->iva }}</p></div>
                <div class="col-md-4"><p><strong>Total Pagado:</strong> {{ $registro->invoice->total_pagar }}</p></div>
            </div>
        @endif

    </div>
    <div class="card-footer text-muted">
        Registro creado el {{ $registro->created_at->format('d/m/Y \a \l\a\s H:i') }}
    </div>
</div>
@endsection