<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SISAL</title>

    <meta name="theme-color" content="#dc3545">

    <link rel="manifest" href="/manifest.json">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <link rel="apple-touch-icon" href="/icons/icon-192.png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-body-tertiary">

<nav class="bg-white shadow-sm sticky-top px-4 py-3">
    <div class="d-flex align-items-center justify-content-between">

        <a class="navbar-brand fw-bold text-primary fs-4 text-decoration-none" href="{{ route('dashboard') }}">
            🚨 SISAL
        </a>

        <div class="d-flex align-items-center gap-4">

            @if(tienePermiso('dashboard'))
                <a href="{{ route('dashboard') }}"
                    class="{{ request()->routeIs('dashboard') ? 'text-primary' : 'text-dark' }} fw-semibold text-decoration-none">
                    <i class="bi bi-house-door"></i> Dashboard
                </a>
            @endif

            @if(tienePermiso('anexos'))
                <a href="{{ route('anexos.index') }}"
                    class="{{ request()->routeIs('anexos.*') ? 'text-primary' : 'text-dark' }} fw-semibold text-decoration-none">
                    <i class="bi bi-geo-alt"></i> Anexos
                </a>
            @endif

            @if(tienePermiso('vecinos'))
                <a href="{{ route('vecinos.index') }}"
                    class="{{ request()->routeIs('vecinos.*') ? 'text-primary' : 'text-dark' }} fw-semibold text-decoration-none">
                    <i class="bi bi-people"></i> Vecinos
                </a>
            @endif

            @if(tienePermiso('alertas'))
                <a href="{{ route('alertas.index') }}"
                    class="{{ request()->routeIs('alertas.*') ? 'text-primary' : 'text-dark' }} fw-semibold text-decoration-none">
                    <i class="bi bi-bell"></i> Alertas
                </a>
            @endif

            @if(tienePermiso('historial'))
                <a href="#" class="text-dark fw-semibold text-decoration-none">
                    <i class="bi bi-clock-history"></i> Historial
                </a>
            @endif

        
            @if(esAdminFull())

                <div class="dropdown">

                    <button class="btn btn-outline-primary rounded-pill dropdown-toggle fw-semibold"
                            data-bs-toggle="dropdown">
                        <i class="bi bi-shield-lock"></i> Administrador
                    </button>

                    <ul class="dropdown-menu shadow border-0 rounded-4 p-2">

                        <li>
                            <a class="dropdown-item rounded-3 py-2"
                               href="{{ route('admin.usuarios.index') }}">
                                <i class="bi bi-people me-2"></i>
                                Usuarios
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item rounded-3 py-2"
                               href="{{ route('admin.permisos') }}">
                                <i class="bi bi-key me-2"></i>
                                Permisos
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item rounded-3 py-2"
                               href="{{ route('admin.modulos.index') }}">
                                <i class="bi bi-grid me-2"></i>
                                Módulos
                            </a>
                        </li>

                    </ul>

                </div>

            @endif


        <div class="dropdown">
            <button class="btn bg-white border-0 dropdown-toggle d-flex align-items-center gap-2 fw-semibold"
                    data-bs-toggle="dropdown">
                <span class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                      style="width:38px;height:38px;">
                    <i class="bi bi-person-fill"></i>
                </span>
                {{ Auth::user()->name }}
            </button>

            <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 p-2">
                <li>
                    <span class="dropdown-item-text text-muted small">
                        Rol: {{ Auth::user()->rol ?? 'SIN ROL' }}
                    </span>
                </li>

                <li>
                    <a class="dropdown-item rounded-3 py-2" href="#">
                        <i class="bi bi-gear me-2"></i> Configuración
                    </a>
                </li>

                <li>
                    <a class="dropdown-item rounded-3 py-2" href="{{ route('profile.edit') }}">
                        <i class="bi bi-person me-2"></i> Perfil
                    </a>
                </li>

                <li><hr class="dropdown-divider"></li>

                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item rounded-3 py-2 text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión
                        </button>
                    </form>
                </li>
            </ul>
        </div>

    </div>
</nav>


@php
    $anexosPush = \App\Models\Anexo::where('estado', 1)
        ->orderBy('nombre')
        ->get();
@endphp

<div class="modal fade" id="modalActivarAlertas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">

            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-bell text-primary me-2"></i>
                    Activar alertas
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Cerrar">
                </button>
            </div>

            <div class="modal-body pt-0">

                <p class="text-muted mb-3">
                    Selecciona el anexo donde deseas recibir las alertas.
                </p>

                <div class="mb-3">
                    <label for="selectAnexoPush" class="form-label fw-semibold">
                        Anexo
                    </label>

                    <select id="selectAnexoPush" class="form-select rounded-3">
                        <option value="">Todo el distrito</option>

                        @foreach($anexosPush as $anexo)
                            <option value="{{ $anexo->id_anexo }}">
                                {{ $anexo->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="alert alert-info rounded-4 mb-0">
                    <i class="bi bi-info-circle me-1"></i>
                    Si eliges “Todo el distrito”, recibirás todas las alertas generales.
                </div>

            </div>

            <div class="modal-footer border-0">
                <button type="button"
                        class="btn btn-light rounded-pill px-4"
                        data-bs-dismiss="modal">
                    Cancelar
                </button>

                <button type="button"
                        id="btnConfirmarActivarPush"
                        class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-bell"></i>
                    Activar
                </button>
            </div>

        </div>
    </div>
</div>

<div class="position-fixed"
     style="right:20px;bottom:20px;z-index:9999;">

    <button id="btnInstallApp"
            class="btn btn-danger rounded-pill shadow-lg px-4"
            style="display:none;">
        <i class="bi bi-phone"></i>
        Instalar App
    </button>

    <button id="btnActivarPush"
            type="button"
            class="btn btn-primary rounded-pill shadow-lg px-4 mt-2"
            data-bs-toggle="modal"
            data-bs-target="#modalActivarAlertas">
        <i class="bi bi-bell"></i>
        Activar alertas
    </button>

</div>

<main class="container-fluid px-4 py-4">
    @yield('content')
</main>


<script>
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', async () => {

                try {

                    await navigator.serviceWorker.register('/firebase-messaging-sw.js');

                    console.log('Service Worker registrado correctamente');

                } catch (error) {

                    console.error('Error registrando Service Worker:', error);

                }

            });
        }
    });
}

let deferredPrompt;

window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault();
    deferredPrompt = e;

    const installBtn = document.getElementById('btnInstallApp');

    if (installBtn) {
        installBtn.style.display = 'inline-flex';

        installBtn.addEventListener('click', async () => {

            installBtn.style.display = 'none';

            deferredPrompt.prompt();

            await deferredPrompt.userChoice;

            deferredPrompt = null;
        });
    }
});
</script>


<script type="module">
import { initializeApp } from "https://www.gstatic.com/firebasejs/12.13.0/firebase-app.js";
import { getMessaging, getToken, onMessage } from "https://www.gstatic.com/firebasejs/12.13.0/firebase-messaging.js";

const firebaseConfig = {
    apiKey: "AIzaSyDZHzg97344lqzH4fjpb_tda5c0VMO36es",
    authDomain: "sisal-e8016.firebaseapp.com",
    projectId: "sisal-e8016",
    storageBucket: "sisal-e8016.firebasestorage.app",
    messagingSenderId: "473592016862",
    appId: "1:473592016862:web:9dd66833be41b9a5cfb74f",
    measurementId: "G-9EKQLZYZ3V"
};

const appFirebase = initializeApp(firebaseConfig);
const messaging = getMessaging(appFirebase);
const vapidKey = "BHrITCBDpepXq9Keq33G9IhfM2MzSkVSGSspo4vl1Zxm1ifMxBiA_Cy18rUqZMTrs_EAuPc9TUxQ2dm58M6S2rw";

async function registrarTokenFCM(idAnexo = null) {
    try {
        if (!('Notification' in window)) {
            console.log('Este navegador no soporta notificaciones.');
            return;
        }

        console.log('Iniciando activación FCM...');

        const permiso = await Notification.requestPermission();

        if (permiso !== 'granted') {
            alert('No se activaron las notificaciones.');
            return;
        }

        let registroSW = null;

        if ('serviceWorker' in navigator) {

            registroSW = await navigator.serviceWorker.getRegistration('/firebase-messaging-sw.js');

            if (!registroSW) {
                registroSW = await navigator.serviceWorker.register('/firebase-messaging-sw.js');
            }

        } else {
            alert('Este navegador no soporta Service Workers.');
            return;
        }

        const token = await getToken(messaging, {
            vapidKey: vapidKey,
            serviceWorkerRegistration: registroSW
        });

        if (!token) {
            alert('No se pudo obtener el token del dispositivo.');
            return;
        }

        await fetch("{{ route('device-tokens.store') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            body: JSON.stringify({
                token: token,
                id_anexo: idAnexo || null,
                plataforma: navigator.platform || 'web',
                navegador: navigator.userAgent
            })
        });

        alert('Notificaciones activadas correctamente.');

    } catch (error) {
        console.error('Error activando notificaciones:', error);
        alert('No se pudieron activar las notificaciones. Revisa la consola.');
    }
}

const btnConfirmarPush = document.getElementById('btnConfirmarActivarPush');

if (btnConfirmarPush) {
    btnConfirmarPush.addEventListener('click', async () => {
        const selectAnexo = document.getElementById('selectAnexoPush');
        const idAnexo = selectAnexo ? selectAnexo.value : null;

        await registrarTokenFCM(idAnexo);

        const modalElement = document.getElementById('modalActivarAlertas');

        if (modalElement) {
            const modal = window.bootstrap?.Modal?.getInstance(modalElement);
            if (modal) {
                modal.hide();
            }
        }
    });
}

onMessage(messaging, (payload) => {
    const titulo = payload.notification?.title || 'Nueva alerta SISAL';
    const mensaje = payload.notification?.body || 'Se ha registrado una nueva alerta.';

    new Notification(titulo, {
        body: mensaje,
        icon: '/icons/icon-192.png'
    });
});
</script>

</body>
</html>
