<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Modulo;
use App\Models\User;
use App\Models\UsuarioPermiso;
use Illuminate\Http\Request;

class PermisoController extends Controller
{
    public function index(Request $request)
    {
        $usuarios = User::where('rol', 'SUBADMIN')
            ->where('estado', 1)
            ->orderBy('name')
            ->get();

        $modulos = Modulo::where('estado', 1)
            ->orderBy('nombre')
            ->get();

        $usuarioSeleccionado = null;
        $permisos = [];

        if ($request->filled('usuario')) {

            $usuarioSeleccionado = User::find($request->usuario);

            $permisos = UsuarioPermiso::where('id_usuario', $request->usuario)
                ->get()
                ->keyBy('id_modulo');
        }

        return view('admin.permisos', compact(
            'usuarios',
            'modulos',
            'usuarioSeleccionado',
            'permisos'
        ));
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|exists:users,id',
        ]);

        foreach ($request->modulos ?? [] as $idModulo => $acciones) {

            UsuarioPermiso::updateOrCreate(
                [
                    'id_usuario' => $request->id_usuario,
                    'id_modulo' => $idModulo,
                ],
                [
                    'puede_ver' => isset($acciones['puede_ver']) ? 1 : 0,
                    'puede_crear' => isset($acciones['puede_crear']) ? 1 : 0,
                    'puede_editar' => isset($acciones['puede_editar']) ? 1 : 0,
                    'puede_eliminar' => isset($acciones['puede_eliminar']) ? 1 : 0,
                    'puede_enviar' => isset($acciones['puede_enviar']) ? 1 : 0,
                    'estado' => 1,
                    'fechaedita' => now(),
                    'fechacrea' => now(),
                ]
            );
        }

        return redirect()
            ->route('admin.permisos', ['usuario' => $request->id_usuario])
            ->with('success', 'Permisos actualizados correctamente.');
    }
}
