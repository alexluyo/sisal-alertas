<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anexo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::orderBy('id', 'desc')->get();

        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $anexos = Anexo::where('estado', 1)
            ->orderBy('nombre')
            ->get();

        return view('admin.usuarios.create', compact('anexos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'rol' => 'required|in:ADMIN_FULL,SUBADMIN',
            'id_anexo' => 'nullable|exists:anexos,id_anexo',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
            'id_anexo' => $request->id_anexo,
            'estado' => 1,
            'fechacrea' => now(),
        ]);

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Usuario registrado correctamente.');
    }

    public function edit(User $usuario)
    {
        $anexos = Anexo::where('estado', 1)
            ->orderBy('nombre')
            ->get();

        return view('admin.usuarios.edit', compact('usuario', 'anexos'));
    }

    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $usuario->id,
            'password' => 'nullable|string|min:6',
            'rol' => 'required|in:ADMIN_FULL,SUBADMIN',
            'id_anexo' => 'nullable|exists:anexos,id_anexo',
        ]);

        $datos = [
            'name' => $request->name,
            'email' => $request->email,
            'rol' => $request->rol,
            'id_anexo' => $request->id_anexo,
            'fechaedita' => now(),
        ];

        if ($request->filled('password')) {
            $datos['password'] = Hash::make($request->password);
        }

        $usuario->update($datos);

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function cambiarEstado(User $usuario)
    {
        $nuevoEstado = $usuario->estado == 1 ? 0 : 1;

        $usuario->update([
            'estado' => $nuevoEstado,
            'fechaedita' => now(),
            'fechaelimina' => $nuevoEstado == 0 ? now() : null,
        ]);

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Estado del usuario actualizado.');
    }

    public function destroy(User $usuario)
    {
        $usuario->update([
            'estado' => 0,
            'fechaelimina' => now(),
        ]);

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Usuario desactivado correctamente.');
    }
}
