@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Editar Usuario</h2>
        <p class="text-muted mb-0">Actualizar datos del usuario.</p>
    </div>

    <a href="{{ route('admin.usuarios.index') }}"
       class="btn btn-outline-secondary rounded-pill px-4">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">

        @if ($errors->any())
            <div class="alert alert-danger rounded-4">
                Revisa los datos ingresados.
            </div>
        @endif

        <form action="{{ route('admin.usuarios.update', $usuario->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Nombre</label>
                    <input type="text"
                           name="name"
                           value="{{ old('name', $usuario->name) }}"
                           class="form-control rounded-4 @error('name') is-invalid @enderror">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Correo</label>
                    <input type="email"
                           name="email"
                           value="{{ old('email', $usuario->email) }}"
                           class="form-control rounded-4 @error('email') is-invalid @enderror">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Nueva contraseña</label>
                    <input type="password"
                           name="password"
                           class="form-control rounded-4 @error('password') is-invalid @enderror"
                           placeholder="Dejar vacío para no cambiar">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Rol</label>
                    <select name="rol"
                            class="form-select rounded-4 @error('rol') is-invalid @enderror">
                        <option value="SUBADMIN" {{ old('rol', $usuario->rol) == 'SUBADMIN' ? 'selected' : '' }}>
                            SUBADMIN
                        </option>
                        <option value="ADMIN_FULL" {{ old('rol', $usuario->rol) == 'ADMIN_FULL' ? 'selected' : '' }}>
                            ADMIN_FULL
                        </option>
                    </select>
                    @error('rol')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-4">
                    <label class="form-label fw-semibold">Anexo asignado</label>
                    <select name="id_anexo"
                            class="form-select rounded-4 @error('id_anexo') is-invalid @enderror">
                        <option value="">Todos / No asignado</option>
                        @foreach($anexos as $anexo)
                            <option value="{{ $anexo->id_anexo }}"
                                {{ old('id_anexo', $usuario->id_anexo) == $anexo->id_anexo ? 'selected' : '' }}>
                                {{ $anexo->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_anexo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="text-end">
                <a href="{{ route('admin.usuarios.index') }}"
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
