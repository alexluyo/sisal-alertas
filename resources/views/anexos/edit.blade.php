@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Editar Anexo</h2>
        <p class="text-muted mb-0">Actualizar información del anexo.</p>
    </div>

    <a href="{{ route('anexos.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">

        @if ($errors->any())
            <div class="alert alert-danger rounded-4">
                <strong>Revisa los datos ingresados.</strong>
            </div>
        @endif

        <form action="{{ route('anexos.update', $anexo->id_anexo) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold">Nombre del anexo</label>
                <input type="text"
                       name="nombre"
                       class="form-control rounded-4 @error('nombre') is-invalid @enderror"
                       value="{{ old('nombre', $anexo->nombre) }}"
                       placeholder="Ejemplo: San Juan">
                @error('nombre')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Descripción</label>
                <textarea name="descripcion"
                          class="form-control rounded-4 @error('descripcion') is-invalid @enderror"
                          rows="4"
                          placeholder="Descripción opcional">{{ old('descripcion', $anexo->descripcion) }}</textarea>
                @error('descripcion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="text-end">
                <a href="{{ route('anexos.index') }}" class="btn btn-light rounded-pill px-4">
                    Cancelar
                </a>

                <button class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-save"></i> Actualizar
                </button>
            </div>
        </form>

    </div>
</div>

@endsection
