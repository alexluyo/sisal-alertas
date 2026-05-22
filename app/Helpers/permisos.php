<?php

use Illuminate\Support\Facades\Auth;

if (! function_exists('esAdminFull')) {
    function esAdminFull(): bool
    {
        return Auth::check() && Auth::user()->rol === 'ADMIN_FULL';
    }
}

if (! function_exists('tienePermiso')) {
    function tienePermiso(string $modulo, string $accion = 'puede_ver'): bool
    {
        return Auth::check() && Auth::user()->tienePermiso($modulo, $accion);
    }
}
