@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Anexos</h2>
        <p class="text-muted mb-0">Gestión de anexos del distrito.</p>
    </div>

    <a href="{{ route('anexos.create') }}" class="btn btn-primary rounded-pill px-4">
        <i class="bi bi-plus-circle"></i> Nuevo Anexo
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success border-0 rounded-4 shadow-sm">
        <i class="bi bi-check-circle"></i> {{ session('success') }}
    </div>
@endif

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($anexos as $anexo)
                        <tr>
                            <td>{{ $anexo->id_anexo }}</td>
                            <td class="fw-semibold">{{ $anexo->nombre }}</td>
                            <td>{{ $anexo->descripcion ?? '-' }}</td>
                            <td>
                                <span class="badge bg-success">Activo</span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('anexos.edit', $anexo->id_anexo) }}"
                                   class="btn btn-sm btn-outline-primary rounded-pill">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>

                                <form action="{{ route('anexos.eliminar', $anexo->id_anexo) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('¿Seguro que deseas eliminar este anexo?')">
                                    @csrf
                                    @method('PATCH')

                                    <button class="btn btn-sm btn-outline-danger rounded-pill">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                No hay anexos registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
