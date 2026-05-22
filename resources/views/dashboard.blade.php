@extends('layouts.app')

@section('content')

<div class="row align-items-center mb-4">
    <div class="col-md-8">
        <h2 class="fw-bold mb-1">Panel de Alertas</h2>
        <p class="text-muted mb-0">Sistema local de alertas por distrito, anexo y sector.</p>
    </div>

    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <a href="{{ route('alertas.create') }}" class="btn btn-danger rounded-pill px-4 py-2 shadow-sm">
            <i class="bi bi-broadcast"></i> Nueva Alerta
        </a>
    </div>
</div>

<div class="row g-4 mb-4">

    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-2">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <p class="text-muted mb-1">Vecinos registrados</p>
                    <h2 class="fw-bold mb-0">{{ $totalVecinos }}</h2>
                </div>

                <div class="rounded-4 bg-primary bg-opacity-10 text-primary p-3 fs-3">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-2">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <p class="text-muted mb-1">Anexos</p>
                    <h2 class="fw-bold mb-0">{{ $totalAnexos }}</h2>
                </div>

                <div class="rounded-4 bg-success bg-opacity-10 text-success p-3 fs-3">
                    <i class="bi bi-geo-alt-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-2">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <p class="text-muted mb-1">Alertas enviadas</p>
                    <h2 class="fw-bold mb-0">{{ $totalAlertas }}</h2>
                </div>

                <div class="rounded-4 bg-danger bg-opacity-10 text-danger p-3 fs-3">
                    <i class="bi bi-bell-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-2">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <p class="text-muted mb-1">Dispositivos activos</p>
                    <h2 class="fw-bold mb-0">0</h2>
                </div>

                <div class="rounded-4 bg-warning bg-opacity-10 text-warning p-3 fs-3">
                    <i class="bi bi-phone-fill"></i>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row g-4">

    <div class="col-lg-8">

        <div class="card border-0 shadow-sm rounded-4 h-100">

            <div class="card-body p-4">

                <h5 class="fw-bold mb-4">
                    <i class="bi bi-clock-history me-2"></i>
                    Alertas recientes
                </h5>

                @forelse($alertasRecientes as $alerta)

                    <div class="border rounded-4 p-3 mb-3 bg-light">

                        <div class="d-flex justify-content-between align-items-start">

                            <div>

                                <span class="badge bg-{{ $alerta->tipo->color ?? 'secondary' }}">
                                    {{ $alerta->tipo->nombre ?? 'Alerta' }}
                                </span>

                                <h6 class="fw-bold mt-2 mb-1">
                                    {{ $alerta->titulo }}
                                </h6>

                                <p class="text-muted mb-2">
                                    {{ $alerta->mensaje }}
                                </p>

                                @if($alerta->evidencia)

                                    <div class="mb-2">
                                        <button type="button"
                                                class="btn btn-outline-primary rounded-pill btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalDashboardEvidencia{{ $alerta->id_alerta }}">
                                            <i class="bi bi-image"></i> Ver evidencia
                                        </button>
                                    </div>

                                    <div class="modal fade"
                                         id="modalDashboardEvidencia{{ $alerta->id_alerta }}"
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

                                <small class="text-muted">
                                    <i class="bi bi-geo-alt"></i>
                                    {{ $alerta->anexo->nombre ?? 'Todo el distrito' }}
                                </small>

                            </div>

                            <small class="text-muted">
                                {{ $alerta->fecha_envio }}
                            </small>

                        </div>

                    </div>

                @empty

                    <div class="border rounded-4 p-4 bg-light">

                        <div class="d-flex align-items-center gap-3">

                            <div class="fs-2 text-primary">
                                <i class="bi bi-info-circle"></i>
                            </div>

                            <div>
                                <h6 class="fw-bold mb-1 text-primary">
                                    No hay alertas registradas todavía.
                                </h6>

                                <p class="text-muted mb-0">
                                    Cuando se registren nuevas alertas aparecerán aquí.
                                </p>
                            </div>

                        </div>

                    </div>

                @endforelse

            </div>

        </div>

    </div>

    <div class="col-lg-4">

        <div class="card border-0 shadow-sm rounded-4 h-100">

            <div class="card-body p-4">

                <h5 class="fw-bold mb-4">
                    <i class="bi bi-lightning-charge me-2"></i>
                    Accesos rápidos
                </h5>

                <div class="row g-3">

                    <div class="col-6">
                        <a href="{{ route('alertas.create', ['tipo' => 5]) }}"
                           class="text-decoration-none">
                            <div class="card border-0 shadow-sm rounded-4 text-center p-3 h-100 hover-card">
                                <div class="text-warning fs-1">
                                    <i class="bi bi-water"></i>
                                </div>
                                <div class="fw-semibold text-warning mt-2">
                                    Huaico
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-6">
                        <a href="{{ route('alertas.create', ['tipo' => 11]) }}"
                           class="text-decoration-none">
                            <div class="card border-0 shadow-sm rounded-4 text-center p-3 h-100 hover-card">
                                <div class="text-danger fs-1">
                                    <i class="bi bi-fire"></i>
                                </div>
                                <div class="fw-semibold text-danger mt-2">
                                    Incendios
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-6">
                        <a href="{{ route('alertas.create', ['tipo' => 3]) }}"
                           class="text-decoration-none">
                            <div class="card border-0 shadow-sm rounded-4 text-center p-3 h-100 hover-card">
                                <div class="text-primary fs-1">
                                    <i class="bi bi-search"></i>
                                </div>
                                <div class="fw-semibold text-primary mt-2">
                                    Personas perdidas
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-6">
                        <a href="{{ route('alertas.create', ['tipo' => 2]) }}"
                           class="text-decoration-none">
                            <div class="card border-0 shadow-sm rounded-4 text-center p-3 h-100 hover-card">
                                <div class="text-warning fs-1">
                                    <i class="bi bi-person-exclamation"></i>
                                </div>
                                <div class="fw-semibold text-warning mt-2">
                                    Sospechosos
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-6">
                        <a href="{{ route('alertas.create', ['tipo' => 1]) }}"
                           class="text-decoration-none">
                            <div class="card border-0 shadow-sm rounded-4 text-center p-3 h-100 hover-card">
                                <div class="text-danger fs-1">
                                    <i class="bi bi-shield-exclamation"></i>
                                </div>
                                <div class="fw-semibold text-danger mt-2">
                                    Robos
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-6">
                        <a href="{{ route('alertas.create', ['tipo' => 4]) }}"
                           class="text-decoration-none">
                            <div class="card border-0 shadow-sm rounded-4 text-center p-3 h-100 hover-card">
                                <div class="text-info fs-1">
                                    <i class="bi bi-cloud-rain-heavy"></i>
                                </div>
                                <div class="fw-semibold text-info mt-2">
                                    Lluvias
                                </div>
                            </div>
                        </a>
                    </div>

                </div>

                <style>
                    .hover-card {
                        transition: .2s ease;
                    }

                    .hover-card:hover {
                        transform: translateY(-4px);
                    }
                </style>

            </div>

        </div>

    </div>

</div>

@endsection
