<?php

namespace App\Http\Controllers;

use App\Models\Anexo;
use Illuminate\Http\Request;

class AnexoController extends Controller
{
    public function index()
    {
        $anexos = Anexo::where('estado', 1)
            ->orderBy('id_anexo', 'desc')
            ->get();

        return view('anexos.index', compact('anexos'));
    }

    public function create()
    {
        return view('anexos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string|max:255',
        ]);

        Anexo::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'estado' => 1,
            'fechacrea' => now(),
        ]);

        return redirect()
            ->route('anexos.index')
            ->with('success', 'Anexo registrado correctamente.');
    }

    public function edit(Anexo $anexo)
    {
        return view('anexos.edit', compact('anexo'));
    }

    public function update(Request $request, Anexo $anexo)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string|max:255',
        ]);

        $anexo->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'fechaedita' => now(),
        ]);

        return redirect()
            ->route('anexos.index')
            ->with('success', 'Anexo actualizado correctamente.');
    }

    public function eliminar(Anexo $anexo)
    {
        $anexo->update([
            'estado' => 0,
            'fechaelimina' => now(),
        ]);

        return redirect()
            ->route('anexos.index')
            ->with('success', 'Anexo eliminado correctamente.');
    }
}
