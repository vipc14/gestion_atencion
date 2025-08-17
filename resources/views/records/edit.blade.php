@extends('layouts.app')

@section('title', 'Editar Registro')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Editar Registro de Atención #{{ $registro->id }}</h2>
            <a class="btn btn-primary" href="{{ route('registros.index') }}">
                <i class="fas fa-arrow-left"></i> Volver al Listado
            </a>
        </div>
    </div>
</div>

<form action="{{ route('registros.update', $registro->id) }}" method="POST">
    @method('PUT')
    @include('records._form')
</form>

@endsection
