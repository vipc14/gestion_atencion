@extends('layouts.app')

@section('title', 'Lista de Registros')

@section('content')
<div class="row mb-3">
    <div class="col-lg-12 d-flex justify-content-between align-items-center">
        <h2>Listado de Registros de Atención</h2>
        <a class="btn btn-success" href="{{ route('registros.create') }}">
            <i class="fas fa-plus"></i> Crear Nuevo Registro
        </a>
    </div>
</div>

<div class="row mb-3">
    <div class="col-lg-12">
        <form action="{{ route('registros.index') }}" method="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Buscar por nombre, cédula, contrato..." value="{{ request('search') }}">
                <button class="btn btn-outline-primary" type="submit"><i class="fas fa-search"></i> Buscar</button>
                <a href="{{ route('registros.index') }}" class="btn btn-outline-secondary"><i class="fas fa-sync-alt"></i> Limpiar</a>
            </div>
        </form>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead class="table-primary">
            <tr>
                <th scope="col">Nº</th>
                <th scope="col">Fecha</th>
                <th scope="col">Cédula/RIF</th>
                <th scope="col">Titular</th>
                <th scope="col">Canal</th>
                <th scope="col">Motivo de Contacto</th>
                <th scope="col">Detalle Motivo</th>
                <th scope="col">Estatus</th>
                <th scope="col" style="width: 150px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($records as $record)
            <tr>
                <th scope="row">{{ $record->id }}</th>
                <td>{{ $record->fecha_atencion->format('d/m/Y') }}</td>
                <td>{{ $record->nombre_titular }} {{ $record->apellido_titular }}</td>
                <td>{{ $record->nacionalidad }}-{{ $record->cedula_rif }}</td>
                <td>{{ $record->attentionChannel?->name ?? 'N/A' }}</td>
                <td>{{ $record->contactReason?->name ?? 'N/A' }}</td>
                <td>{{ $record->reasonDetail?->name ?? 'N/A' }}</td>
                <td>
                    <span class="badge {{ $record->estatus == 'Abierto' ? 'bg-warning text-dark' : 'bg-success' }}">
                        {{ $record->estatus }}
                    </span>
                </td>
                <td>
                    <form action="{{ route('registros.destroy', $record->id) }}" method="POST" class="d-inline">
                        <a class="btn btn-info btn-sm" href="{{ route('registros.show', $record->id) }}" title="Ver"><i class="fas fa-eye"></i></a>
                        <a class="btn btn-primary btn-sm" href="{{ route('registros.edit', $record->id) }}" title="Editar"><i class="fas fa-edit"></i></a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar este registro?')"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center">No hay registros para mostrar.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{!! $records->links() !!}

@endsection