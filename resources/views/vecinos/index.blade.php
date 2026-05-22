@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Vecinos</h2>
        <p class="text-muted mb-0">Gestión de vecinos registrados.</p>
    </div>

    <a href="{{ route('vecinos.create') }}" class="btn btn-primary rounded-pill px-4">
        <i class="bi bi-plus-circle"></i> Nuevo Vecino
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success border-0 rounded-4 shadow-sm">
        {{ session('success') }}
    </div>
@endif

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>DNI</th>
                        <th>Nombres</th>
                        <th>Celular</th>
                        <th>Anexo</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($vecinos as $vecino)
                        <tr>
                            <td>{{ $vecino->id_vecino }}</td>
                            <td>{{ $vecino->dni }}</td>
                            <td class="fw-semibold">{{ $vecino->nombres }}</td>
                            <td>{{ $vecino->celular }}</td>
                            <td>{{ $vecino->anexo->nombre ?? '-' }}</td>

                            <td class="text-end">

                                <a href="{{ route('vecinos.edit', $vecino->id_vecino) }}"
                                   class="btn btn-sm btn-outline-primary rounded-pill">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>

                                <form action="{{ route('vecinos.eliminar', $vecino->id_vecino) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('¿Eliminar vecino?')">

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
                            <td colspan="6" class="text-center text-muted py-4">
                                No hay vecinos registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
</div>

@endsection
