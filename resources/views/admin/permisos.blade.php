@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2 class="fw-bold mb-1">
            <i class="bi bi-key"></i>
            Gestión de Permisos
        </h2>

        <p class="text-muted mb-0">
            Asigna permisos por módulo a cada subadministrador.
        </p>
    </div>

</div>

@if(session('success'))
    <div class="alert alert-success rounded-4 border-0 shadow-sm">
        {{ session('success') }}
    </div>
@endif

<div class="card border-0 shadow-sm rounded-4 mb-4">

    <div class="card-body p-4">

        <form method="GET" action="{{ route('admin.permisos') }}">

            <div class="row align-items-end">

                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Seleccionar Subadministrador
                    </label>

                    <select name="usuario"
                            class="form-select rounded-4"
                            onchange="this.form.submit()">

                        <option value="">Seleccione</option>

                        @foreach($usuarios as $usuario)

                            <option value="{{ $usuario->id }}"
                                {{ request('usuario') == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->name }}
                            </option>

                        @endforeach

                    </select>
                </div>

            </div>

        </form>

    </div>

</div>

@if($usuarioSeleccionado)

<form method="POST" action="{{ route('admin.permisos.guardar') }}">
    @csrf

    <input type="hidden"
           name="id_usuario"
           value="{{ $usuarioSeleccionado->id }}">

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body p-4">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>
                    <h5 class="fw-bold mb-1">
                        {{ $usuarioSeleccionado->name }}
                    </h5>

                    <small class="text-muted">
                        Configuración de accesos
                    </small>
                </div>

                <button class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-save"></i>
                    Guardar permisos
                </button>

            </div>

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>
                            <th>Módulo</th>
                            <th class="text-center">Ver</th>
                            <th class="text-center">Crear</th>
                            <th class="text-center">Editar</th>
                            <th class="text-center">Eliminar</th>
                            <th class="text-center">Enviar</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach($modulos as $modulo)

                            @php
                                $permiso = $permisos[$modulo->id_modulo] ?? null;
                            @endphp

                            <tr>

                                <td class="fw-semibold">
                                    {{ $modulo->nombre }}
                                </td>

                                <td class="text-center">
                                    <input type="checkbox"
                                           name="modulos[{{ $modulo->id_modulo }}][puede_ver]"
                                           {{ $permiso && $permiso->puede_ver ? 'checked' : '' }}>
                                </td>

                                <td class="text-center">
                                    <input type="checkbox"
                                           name="modulos[{{ $modulo->id_modulo }}][puede_crear]"
                                           {{ $permiso && $permiso->puede_crear ? 'checked' : '' }}>
                                </td>

                                <td class="text-center">
                                    <input type="checkbox"
                                           name="modulos[{{ $modulo->id_modulo }}][puede_editar]"
                                           {{ $permiso && $permiso->puede_editar ? 'checked' : '' }}>
                                </td>

                                <td class="text-center">
                                    <input type="checkbox"
                                           name="modulos[{{ $modulo->id_modulo }}][puede_eliminar]"
                                           {{ $permiso && $permiso->puede_eliminar ? 'checked' : '' }}>
                                </td>

                                <td class="text-center">
                                    <input type="checkbox"
                                           name="modulos[{{ $modulo->id_modulo }}][puede_enviar]"
                                           {{ $permiso && $permiso->puede_enviar ? 'checked' : '' }}>
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</form>

@endif

@endsection
