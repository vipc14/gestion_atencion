@extends('layouts.app')

@section('title', 'Crear Nuevo Registro')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Añadir Nuevo Registro de Atención</h2>
            <a class="btn btn-primary" href="{{ route('registros.index') }}">
                <i class="fas fa-arrow-left"></i> Volver al Listado
            </a>
        </div>
    </div>
</div>

<form action="{{ route('registros.store') }}" method="POST">
    @include('records._form', ['registro' => new \App\Models\CustomerRecord()])
</form>

@endsection
