<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SISAL - Sistema Local de Alertas</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600;700;800;900&display=swap" rel="stylesheet">
</head>

<body class="sisal-login-body">

    <div class="sisal-bg-circle sisal-bg-circle-1"></div>
    <div class="sisal-bg-circle sisal-bg-circle-2"></div>

    <div class="sisal-login-container">

        <div class="sisal-login-left">

            <div>

                <div class="sisal-brand-header">

                    <div class="sisal-brand-icon">
                        🚨
                    </div>

                    <div>
                        <h1>SISAL</h1>
                        <span>Sistema Integrado de Supervisión y Alertas Locales</span>
                    </div>

                </div>

                <div class="sisal-brand-content">

                    <h2>
                        Protegiendo a la comunidad en tiempo real.
                    </h2>

                    <p>
                        Plataforma moderna para gestión de alertas
                        distritales, anexos, incidencias y monitoreo ciudadano.
                    </p>

                </div>

            </div>

            <div class="sisal-graphic">

                <div class="sisal-wave"></div>

                <div class="sisal-stats-panel">

                    <div class="sisal-stat-item">
                        <div class="sisal-stat-icon bg-success-subtle text-success">
                            <i class="bi bi-broadcast"></i>
                        </div>

                        <div>
                            <h4>24/7</h4>
                            <span>Monitoreo activo</span>
                        </div>
                    </div>

                    <div class="sisal-stat-item">
                        <div class="sisal-stat-icon bg-primary-subtle text-primary">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>

                        <div>
                            <h4>Distrital</h4>
                            <span>Cobertura completa</span>
                        </div>
                    </div>

                    <div class="sisal-stat-item">
                        <div class="sisal-stat-icon bg-danger-subtle text-danger">
                            <i class="bi bi-bell-fill"></i>
                        </div>

                        <div>
                            <h4>Tiempo real</h4>
                            <span>Alertas inmediatas</span>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <div class="sisal-login-right">

            <div class="sisal-login-card glass-effect">

                {{ $slot }}

            </div>

            <div class="sisal-footer">
                © {{ date('Y') }} SISAL · Plataforma de monitoreo y alertas
            </div>

        </div>

    </div>

</body>
</html>
