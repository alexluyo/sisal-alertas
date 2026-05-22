@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2 class="fw-bold mb-1">Nueva Alerta</h2>
        <p class="text-muted mb-0">Registrar alerta distrital.</p>
    </div>

    <a href="{{ route('alertas.index') }}"
       class="btn btn-outline-secondary rounded-pill px-4">
        <i class="bi bi-arrow-left"></i> Volver
    </a>

</div>

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body p-4">

        <form action="{{ route('alertas.store') }}" method="POST" enctype="multipart/form-data">

            @csrf

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="form-label fw-semibold">
                        Tipo de alerta
                    </label>

                    <select name="id_tipo_alerta"
                            id="id_tipo_alerta"
                            class="form-select rounded-4">

                        <option value="">Seleccione</option>

                        @foreach($tipos as $tipo)

                            <option value="{{ $tipo->id_tipo_alerta }}"
                                {{ old('id_tipo_alerta', $tipoSeleccionado ?? '') == $tipo->id_tipo_alerta ? 'selected' : '' }}>

                                {{ $tipo->nombre }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label fw-semibold">
                        Anexo
                    </label>

                    @php
                        $usuario = auth()->user();
                    @endphp

                    @if($usuario->rol === 'SUBADMIN' && $usuario->id_anexo)

                        <input type="hidden"
                               name="id_anexo"
                               value="{{ $usuario->id_anexo }}">

                        <input type="text"
                               class="form-control rounded-4"
                               value="{{ $anexos->first()->nombre ?? 'Anexo asignado' }}"
                               readonly>

                        <small class="text-muted">
                            Como subadministrador solo puedes enviar alertas a tu anexo asignado.
                        </small>

                    @else

                        <select name="id_anexo"
                                class="form-select rounded-4">

                            <option value="">Todo el distrito</option>

                            @foreach($anexos as $anexo)

                                <option value="{{ $anexo->id_anexo }}">
                                    {{ $anexo->nombre }}
                                </option>

                            @endforeach

                        </select>

                    @endif

                </div>

                <div class="col-12 mb-3">

                    <label class="form-label fw-semibold">
                        Título
                    </label>

                    <input type="text"
                           name="titulo"
                           id="titulo"
                           class="form-control rounded-4"
                           value="{{ old('titulo', $titulo ?? '') }}">

                </div>

                <div class="col-12 mb-4">

                    <label class="form-label fw-semibold">
                        Mensaje
                    </label>

                    <textarea name="mensaje"
                              id="mensaje"
                              rows="5"
                              class="form-control rounded-4">{{ old('mensaje', $mensaje ?? '') }}</textarea>

                </div>

                <div class="col-12 mb-4">

                    <label class="form-label fw-semibold">
                        Foto o evidencia
                    </label>

                    <input type="file"
                           name="evidencia"
                           accept=".jpg,.jpeg,.png,.webp"
                           class="form-control rounded-4">

                    <small class="text-muted">
                        Puede adjuntar una foto del incidente o evidencia.
                    </small>

                </div>

            </div>

            <div class="text-end">

                <a href="{{ route('alertas.index') }}"
                   class="btn btn-light rounded-pill px-4">
                    Cancelar
                </a>

                <button class="btn btn-danger rounded-pill px-4">
                    <i class="bi bi-send"></i> Enviar Alerta
                </button>

            </div>

        </form>

    </div>

</div>

<script>

document.addEventListener('DOMContentLoaded', function () {

    const tipoSelect = document.getElementById('id_tipo_alerta');
    const tituloInput = document.getElementById('titulo');
    const mensajeInput = document.getElementById('mensaje');

    const plantillas = {

        'Robos': {
            titulo: '🚨 ALERTA POR ROBOS',
            mensaje: 'Se reportan posibles robos en la zona.\nSe recomienda mantener puertas y ventanas aseguradas.\nEvite salir si no es necesario y reporte cualquier actividad sospechosa.'
        },

        'Personas sospechosas': {
            titulo: '⚠️ PERSONAS SOSPECHOSAS',
            mensaje: 'Se reportan personas sospechosas en la zona.\nSe recomienda mantenerse atentos y evitar confrontaciones.\nComunicar cualquier movimiento extraño a las autoridades.'
        },

        'Pérdida de niños o adultos mayores': {
            titulo: '🔎 PERSONA PERDIDA',
            mensaje: 'Se reporta pérdida de niño, adulto mayor o persona vulnerable.\nSe solicita apoyo de los vecinos para brindar información.\nAnte cualquier dato, comunicarse inmediatamente con las autoridades.'
        },

        'Lluvias intensas': {
            titulo: '🌧️ ALERTA POR LLUVIAS INTENSAS',
            mensaje: 'Se reportan lluvias intensas en la zona.\nEvite transitar por zonas inundables o cercanas a quebradas.\nManténgase atento a los comunicados oficiales.'
        },

        'Huaicos': {
            titulo: '🚨 ALERTA POR HUAICO',
            mensaje: 'Se reporta posible huaico.\nSe recomienda a los vecinos alejarse de quebradas, riachuelos y zonas de riesgo.\nMantenerse atentos a las indicaciones de las autoridades.'
        },

        'Inundaciones': {
            titulo: '🌊 ALERTA POR INUNDACIÓN',
            mensaje: 'Se reporta posible inundación en la zona.\nEvite cruzar calles, canales o zonas con acumulación de agua.\nDiríjase a zonas seguras si las autoridades lo indican.'
        },

        'Sismos': {
            titulo: '⚠️ ALERTA POR SISMO',
            mensaje: 'Se ha reportado un movimiento sísmico.\nMantenga la calma, ubíquese en una zona segura y evite usar ascensores.\nRevise posibles daños y siga las indicaciones de las autoridades.'
        },

        'Incendios forestales': {
            titulo: '🔥 ALERTA POR INCENDIO FORESTAL',
            mensaje: 'Se reporta incendio forestal en la zona.\nEvite acercarse al área afectada y no realice quemas.\nPermita el acceso de bomberos y personal de emergencia.'
        },

        'Deslizamientos': {
            titulo: '⚠️ ALERTA POR DESLIZAMIENTO',
            mensaje: 'Se reporta posible deslizamiento en la zona.\nEvite acercarse a laderas, cerros o zonas inestables.\nDiríjase a una zona segura y siga las indicaciones de las autoridades.'
        },

        'Incendios': {
            titulo: '🔥 ALERTA DE INCENDIO',
            mensaje: 'Se reporta incendio en la zona.\nEvite acercarse al área afectada.\nPermita el acceso de bomberos y personal de emergencia.'
        },

        'Accidente de tránsito': {
            titulo: '🚗 ALERTA POR ACCIDENTE DE TRÁNSITO',
            mensaje: 'Se reporta accidente de tránsito en la zona.\nEvite transitar por el área afectada.\nPermita el paso de ambulancias, bomberos y personal de emergencia.'
        }

    };

    tipoSelect.addEventListener('change', function () {

        const texto = this.options[this.selectedIndex].text.trim();

        if (plantillas[texto]) {
            tituloInput.value = plantillas[texto].titulo;
            mensajeInput.value = plantillas[texto].mensaje;
        } else {
            tituloInput.value = '';
            mensajeInput.value = '';
        }

    });


    // Ejecutar automáticamente al cargar
    if (tipoSelect.value !== '') {
        tipoSelect.dispatchEvent(new Event('change'));
    }


});

</script>

@endsection
