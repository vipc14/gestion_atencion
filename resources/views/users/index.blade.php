@extends('layouts.app')

@section('title', 'Gestión de Usuarios')

@section('content')
<div class="row mb-3">
    <div class="col-lg-12 d-flex justify-content-between align-items-center">
        <h2>Gestión de Usuarios</h2>
        <a class="btn btn-success" href="{{ route('usuarios.create') }}">
            <i class="fas fa-plus"></i> Crear Nuevo Usuario
        </a>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead class="table-primary">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Usuario</th>
                <th scope="col">Email</th>
                <th scope="col">Rol</th>
                <th scope="col" style="width: 150px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
            <tr>
                <th scope="row">{{ $user->id }}</th>
                <td>{{ $user->name }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if(!empty($user->getRoleNames()))
                        @foreach($user->getRoleNames() as $roleName)
                            <span class="badge bg-info text-dark">{{ $roleName }}</span>
                        @endforeach
                    @endif
                </td>
                <td>
                    <form action="{{ route('usuarios.destroy', $user->id) }}" method="POST" class="d-inline">
                        <a class="btn btn-primary btn-sm" href="{{ route('usuarios.edit', $user->id) }}" title="Editar"><i class="fas fa-edit"></i></a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar a este usuario? Esta acción no se puede deshacer.')"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">No hay usuarios para mostrar.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
