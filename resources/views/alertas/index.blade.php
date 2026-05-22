@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2 class="fw-bold mb-1">Alertas</h2>
        <p class="text-muted mb-0">Centro de alertas del distrito.</p>
    </div>

    <a href="{{ route('alertas.create') }}"
       class="btn btn-danger rounded-pill px-4 shadow-sm">
        <i class="bi bi-broadcast"></i> Nueva Alerta
    </a>

</div>

@if(session('success'))
    <div class="alert alert-success rounded-4 border-0 shadow-sm">
        {{ session('success') }}
    </div>
@endif

<div class="row g-4 mb-4">

    @foreach($alertas as $alerta)

        <div class="col-lg-6">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-start mb-3">

                        <div>

                            <span class="badge bg-{{ $alerta->tipo->color ?? 'secondary' }} rounded-pill px-3 py-2">
                                <i class="bi {{ $alerta->tipo->icono }}"></i>
                                {{ $alerta->tipo->nombre }}
                            </span>

                        </div>

                        <form action="{{ route('alertas.eliminar', $alerta->id_alerta) }}"
                              method="POST"
                              onsubmit="return confirm('¿Eliminar alerta?')">

                            @csrf
                            @method('PATCH')

                            <button class="btn btn-sm btn-outline-danger rounded-pill">
                                <i class="bi bi-trash"></i>
                            </button>

                        </form>

                    </div>

                    <h5 class="fw-bold">{{ $alerta->titulo }}</h5>

                    <p class="text-muted">
                        {{ $alerta->mensaje }}
                    </p>

                    @if($alerta->evidencia)

                        <div class="mb-3">

                            <button type="button"
                                    class="btn btn-outline-primary rounded-pill btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEvidencia{{ $alerta->id_alerta }}">
                                <i class="bi bi-image"></i> Ver evidencia
                            </button>

                        </div>

                        <div class="modal fade"
                             id="modalEvidencia{{ $alerta->id_alerta }}"
                             tabindex="-1"
                             aria-hidden="true">

                            <div class="modal-dialog modal-dialog-centered modal-xl">

                                <div class="modal-content border-0 rounded-4">

                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold">
                                            Evidencia de alerta
                                        </h5>

                                        <button type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal"
                                                aria-label="Cerrar">
                                        </button>
                                    </div>

                                    <div class="modal-body text-center bg-light">

                                        <img src="{{ asset('storage/' . $alerta->evidencia) }}"
                                             class="img-fluid rounded-4 border shadow-sm"
                                             style="max-height:75vh;object-fit:contain;">

                                    </div>

                                    <div class="modal-footer">

                                        <a href="{{ asset('storage/' . $alerta->evidencia) }}"
                                           target="_blank"
                                           class="btn btn-outline-primary rounded-pill">
                                            <i class="bi bi-box-arrow-up-right"></i> Abrir imagen
                                        </a>

                                        <button type="button"
                                                class="btn btn-secondary rounded-pill"
                                                data-bs-dismiss="modal">
                                            Cerrar
                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endif

                    <div class="d-flex justify-content-between">

                        <small class="text-muted">
                            <i class="bi bi-geo-alt"></i>
                            {{ $alerta->anexo->nombre ?? 'Todo el distrito' }}
                        </small>

                        <small class="text-muted">
                            {{ $alerta->fecha_envio }}
                        </small>

                    </div>

                </div>

            </div>

        </div>

    @endforeach

</div>

@endsection
