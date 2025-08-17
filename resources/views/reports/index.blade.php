    @extends('layouts.app')

    @section('title', 'Reporte de Transacciones')

    @section('content')
    <div class="row mb-3">
        <div class="col-lg-12 d-flex justify-content-between align-items-center">
            <h2>Reporte General de Transacciones</h2>
        </div>
    </div>

    <!-- SECCIÓN DE TOTALES -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Total Pagos (TDD)</h5>
                    <p class="card-text fs-4 fw-bold">{{ number_format($totalPayments, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Total Recargas</h5>
                    <p class="card-text fs-4 fw-bold">{{ number_format($totalRecharges, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Total Facturas (Ventas)</h5>
                    <p class="card-text fs-4 fw-bold">{{ number_format($totalInvoices, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">TOTAL RECAUDADO</h5>
                    <p class="card-text fs-4 fw-bold">{{ number_format($grandTotal, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- TABLA DE PAGOS -->
    <h4 class="mt-5">Pagos con Tarjeta de Débito</h4>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>Reg. Nº</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>C.I. Depositante</th>
                    <th>Plan</th>
                    <th class="text-end">Monto</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                <tr>
                    <td><a href="{{ route('registros.show', $payment->customer_record_id) }}">{{ $payment->customer_record_id }}</a></td>
                    <td>{{ $payment->created_at->format('d/m/Y') }}</td>
                    <td>{{ $payment->customerRecord?->nombre_completo ?? 'N/A' }}</td>
                    <td>{{ $payment->cedula_depositante }}</td>
                    <td>{{ $payment->subscriptionPlan?->name ?? 'N/A' }}</td>
                    <td class="text-end">{{ number_format($payment->total_pagar, 2, ',', '.') }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center">No hay pagos registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- TABLA DE FACTURAS (VENTAS) -->
    <h4 class="mt-5">Facturas (Ventas)</h4>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
             <thead class="table-light">
                <tr>
                    <th>Reg. Nº</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Serial USIM</th>
                    <th class="text-end">Monto</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $invoice)
                <tr>
                    <td><a href="{{ route('registros.show', $invoice->customer_record_id) }}">{{ $invoice->customer_record_id }}</a></td>
                    <td>{{ $invoice->created_at->format('d/m/Y') }}</td>
                    <td>{{ $invoice->customerRecord?->nombre_completo ?? 'N/A' }}</td>
                    <td>{{ $invoice->serial_usim ?? 'N/A' }}</td>
                    <td class="text-end">{{ number_format($invoice->total_pagar, 2, ',', '.') }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center">No hay facturas registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- TABLA DE RECARGAS -->
    <h4 class="mt-5">Recargas Prepago</h4>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
             <thead class="table-light">
                <tr>
                    <th>Reg. Nº</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Nº Confirmación</th>
                    <th class="text-end">Monto</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recharges as $recharge)
                <tr>
                    <td><a href="{{ route('registros.show', $recharge->customer_record_id) }}">{{ $recharge->customer_record_id }}</a></td>
                    <td>{{ $recharge->created_at->format('d/m/Y') }}</td>
                    <td>{{ $recharge->customerRecord?->nombre_completo ?? 'N/A' }}</td>
                    <td>{{ $recharge->numero_confirmacion_payall }}</td>
                    <td class="text-end">{{ number_format($recharge->total_recargar, 2, ',', '.') }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center">No hay recargas registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @endsection
    