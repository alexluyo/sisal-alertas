@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2 class="fw-bold mb-1">
            <i class="bi bi-grid"></i>
            Gestión de Módulos
        </h2>

        <p class="text-muted mb-0">
            Administración de módulos del sistema.
        </p>
    </div>

    <a href="{{ route('admin.modulos.create') }}"
       class="btn btn-primary rounded-pill px-4">
        <i class="bi bi-plus-circle"></i>
        Nuevo módulo
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
                        <th>Módulo</th>
                        <th>Clave</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($modulos as $modulo)

                        <tr>

                            <td>{{ $modulo->id_modulo }}</td>

                            <td class="fw-semibold">
                                {{ $modulo->nombre }}
                            </td>

                            <td>
                                <code>{{ $modulo->clave }}</code>
                            </td>

                            <td>
                                @if($modulo->estado == 1)
                                    <span class="badge bg-success rounded-pill">
                                        Activo
                                    </span>
                                @else
                                    <span class="badge bg-secondary rounded-pill">
                                        Inactivo
                                    </span>
                                @endif
                            </td>

                            <td class="text-end">

                                <a href="{{ route('admin.modulos.edit', $modulo->id_modulo) }}"
                                   class="btn btn-sm btn-outline-primary rounded-pill">
                                    <i class="bi bi-pencil"></i>
                                    Editar
                                </a>

                                <form action="{{ route('admin.modulos.estado', $modulo->id_modulo) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf
                                    @method('PATCH')

                                    <button class="btn btn-sm btn-outline-warning rounded-pill">

                                        @if($modulo->estado == 1)
                                            <i class="bi bi-pause-circle"></i>
                                            Desactivar
                                        @else
                                            <i class="bi bi-check-circle"></i>
                                            Activar
                                        @endif

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                No hay módulos registrados.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
