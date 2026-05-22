<?php

namespace App\Http\Controllers;

use App\Models\Vecino;
use App\Models\Anexo;
use Illuminate\Http\Request;

class VecinoController extends Controller
{
    public function index()
    {
        $vecinos = Vecino::with('anexo')
            ->where('estado', 1)
            ->orderBy('id_vecino', 'desc')
            ->get();

        return view('vecinos.index', compact('vecinos'));
    }

    public function create()
    {
        $anexos = Anexo::where('estado', 1)->get();

        return view('vecinos.create', compact('anexos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dni' => 'nullable|max:15',
            'nombres' => 'required|max:150',
            'celular' => 'nullable|max:20',
            'direccion' => 'nullable|max:200',
            'id_anexo' => 'required'
        ]);

        Vecino::create([
            'dni' => $request->dni,
            'nombres' => $request->nombres,
            'celular' => $request->celular,
            'direccion' => $request->direccion,
            'id_anexo' => $request->id_anexo,
            'estado' => 1,
            'fechacrea' => now()
        ]);

        return redirect()
            ->route('vecinos.index')
            ->with('success', 'Vecino registrado correctamente.');
    }

    public function edit(Vecino $vecino)
    {
        $anexos = Anexo::where('estado', 1)->get();

        return view('vecinos.edit', compact('vecino', 'anexos'));
    }

    public function update(Request $request, Vecino $vecino)
    {
        $request->validate([
            'dni' => 'nullable|max:15',
            'nombres' => 'required|max:150',
            'celular' => 'nullable|max:20',
            'direccion' => 'nullable|max:200',
            'id_anexo' => 'required'
        ]);

        $vecino->update([
            'dni' => $request->dni,
            'nombres' => $request->nombres,
            'celular' => $request->celular,
            'direccion' => $request->direccion,
            'id_anexo' => $request->id_anexo,
            'fechaedita' => now()
        ]);

        return redirect()
            ->route('vecinos.index')
            ->with('success', 'Vecino actualizado correctamente.');
    }

    public function eliminar(Vecino $vecino)
    {
        $vecino->update([
            'estado' => 0,
            'fechaelimina' => now()
        ]);

        return redirect()
            ->route('vecinos.index')
            ->with('success', 'Vecino eliminado correctamente.');
    }
}
