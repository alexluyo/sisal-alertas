<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Modulo;
use Illuminate\Http\Request;

class ModuloController extends Controller
{
    public function index()
    {
        $modulos = Modulo::orderBy('id_modulo', 'desc')->get();

        return view('admin.modulos.index', compact('modulos'));
    }

    public function create()
    {
        return view('admin.modulos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'clave' => 'required|string|max:100|unique:modulos,clave',
        ]);

        Modulo::create([
            'nombre' => $request->nombre,
            'clave' => strtolower($request->clave),
            'estado' => 1,
            'fechacrea' => now(),
        ]);

        return redirect()
            ->route('admin.modulos.index')
            ->with('success', 'Módulo registrado correctamente.');
    }

    public function edit(Modulo $modulo)
    {
        return view('admin.modulos.edit', compact('modulo'));
    }

    public function update(Request $request, Modulo $modulo)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'clave' => 'required|string|max:100|unique:modulos,clave,' . $modulo->id_modulo . ',id_modulo',
        ]);

        $modulo->update([
            'nombre' => $request->nombre,
            'clave' => strtolower($request->clave),
            'fechaedita' => now(),
        ]);

        return redirect()
            ->route('admin.modulos.index')
            ->with('success', 'Módulo actualizado correctamente.');
    }

    public function cambiarEstado(Modulo $modulo)
    {
        $nuevoEstado = $modulo->estado == 1 ? 0 : 1;

        $modulo->update([
            'estado' => $nuevoEstado,
            'fechaedita' => now(),
            'fechaelimina' => $nuevoEstado == 0 ? now() : null,
        ]);

        return redirect()
            ->route('admin.modulos.index')
            ->with('success', 'Estado actualizado correctamente.');
    }
}
