@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2 class="fw-bold mb-1">Editar Vecino</h2>
        <p class="text-muted mb-0">Actualizar datos del vecino.</p>
    </div>

    <a href="{{ route('vecinos.index') }}"
       class="btn btn-outline-secondary rounded-pill px-4">
        <i class="bi bi-arrow-left"></i> Volver
    </a>

</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">

        <form action="{{ route('vecinos.update', $vecino->id_vecino) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">DNI</label>

                    <input type="text"
                           name="dni"
                           class="form-control rounded-4"
                           value="{{ old('dni', $vecino->dni) }}">
                </div>

                <div class="col-md-8 mb-3">
                    <label class="form-label fw-semibold">Nombres</label>

                    <input type="text"
                           name="nombres"
                           class="form-control rounded-4"
                           value="{{ old('nombres', $vecino->nombres) }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Celular</label>

                    <input type="text"
                           name="celular"
                           class="form-control rounded-4"
                           value="{{ old('celular', $vecino->celular) }}">
                </div>

                <div class="col-md-8 mb-3">
                    <label class="form-label fw-semibold">Dirección</label>

                    <input type="text"
                           name="direccion"
                           class="form-control rounded-4"
                           value="{{ old('direccion', $vecino->direccion) }}">
                </div>

                <div class="col-md-6 mb-4">
                    <label class="form-label fw-semibold">Anexo</label>

                    <select name="id_anexo"
                            class="form-select rounded-4">

                        @foreach($anexos as $anexo)
                            <option value="{{ $anexo->id_anexo }}"
                                {{ $vecino->id_anexo == $anexo->id_anexo ? 'selected' : '' }}>
                                {{ $anexo->nombre }}
                            </option>
                        @endforeach

                    </select>
                </div>

            </div>

            <div class="text-end">

                <a href="{{ route('vecinos.index') }}"
                   class="btn btn-light rounded-pill px-4">
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
