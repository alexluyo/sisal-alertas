@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">
            <i class="bi bi-people"></i> Administración de Usuarios
        </h2>
        <p class="text-muted mb-0">Crea administradores y subadministradores del sistema.</p>
    </div>

    <a href="{{ route('admin.usuarios.create') }}"
       class="btn btn-primary rounded-pill px-4">
        <i class="bi bi-plus-circle"></i> Nuevo Usuario
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success rounded-4 border-0 shadow-sm">
        {{ session('success') }}
    </div>
@endif

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Usuario</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Anexo asignado</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->id }}</td>

                            <td class="fw-semibold">
                                {{ $usuario->name }}
                            </td>

                            <td>{{ $usuario->email }}</td>

                            <td>
                                @if($usuario->rol === 'ADMIN_FULL')
                                    <span class="badge bg-primary rounded-pill">
                                        ADMIN_FULL
                                    </span>
                                @else
                                    <span class="badge bg-info rounded-pill">
                                        SUBADMIN
                                    </span>
                                @endif
                            </td>

                            <td>
                                {{ $usuario->anexo->nombre ?? 'Todos / No asignado' }}
                            </td>

                            <td>
                                @if($usuario->estado == 1)
                                    <span class="badge bg-success rounded-pill">Activo</span>
                                @else
                                    <span class="badge bg-secondary rounded-pill">Inactivo</span>
                                @endif
                            </td>

                            <td class="text-end">

                                <a href="{{ route('admin.usuarios.edit', $usuario->id) }}"
                                   class="btn btn-sm btn-outline-primary rounded-pill">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>

                                <form action="{{ route('admin.usuarios.estado', $usuario->id) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf
                                    @method('PATCH')

                                    <button class="btn btn-sm btn-outline-warning rounded-pill">
                                        @if($usuario->estado == 1)
                                            <i class="bi bi-pause-circle"></i> Desactivar
                                        @else
                                            <i class="bi bi-check-circle"></i> Activar
                                        @endif
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                No hay usuarios registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection
