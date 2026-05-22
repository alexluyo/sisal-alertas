@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2 class="fw-bold mb-1">Editar Módulo</h2>
        <p class="text-muted mb-0">Actualizar módulo del sistema.</p>
    </div>

    <a href="{{ route('admin.modulos.index') }}"
       class="btn btn-outline-secondary rounded-pill px-4">
        <i class="bi bi-arrow-left"></i>
        Volver
    </a>

</div>

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body p-4">

        <form action="{{ route('admin.modulos.update', $modulo->id_modulo) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="mb-4">

                <label class="form-label fw-semibold">
                    Nombre del módulo
                </label>

                <input type="text"
                       name="nombre"
                       value="{{ old('nombre', $modulo->nombre) }}"
                       class="form-control rounded-4">

            </div>

            <div class="mb-4">

                <label class="form-label fw-semibold">
                    Clave interna
                </label>

                <input type="text"
                       name="clave"
                       value="{{ old('clave', $modulo->clave) }}"
                       class="form-control rounded-4">

            </div>

            <div class="text-end">

                <a href="{{ route('admin.modulos.index') }}"
                   class="btn btn-light rounded-pill px-4">
                    Cancelar
                </a>

                <button class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-save"></i>
                    Actualizar
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
