<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarPermiso
{
    public function handle(Request $request, Closure $next, string $modulo, string $accion = 'puede_ver'): Response
    {
        $usuario = $request->user();

        if (!$usuario) {
            abort(403, 'No autenticado.');
        }

        if (!$usuario->tienePermiso($modulo, $accion)) {
            abort(403, 'No tienes permiso para acceder a este módulo.');
        }

        return $next($request);
    }
}
