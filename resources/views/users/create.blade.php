@extends('layouts.app')

@section('title', 'Crear Nuevo Usuario')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Añadir Nuevo Usuario</h2>
            <a class="btn btn-primary" href="{{ route('usuarios.index') }}">
                <i class="fas fa-arrow-left"></i> Volver al Listado
            </a>
        </div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>¡Vaya!</strong> Hubo algunos problemas con tu entrada.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('usuarios.store') }}" method="POST">
    @include('users._form')
</form>

@endsection
