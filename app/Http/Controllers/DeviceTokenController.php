<?php

namespace App\Http\Controllers;

use App\Models\DeviceToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeviceTokenController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'id_anexo' => 'nullable|exists:anexos,id_anexo',
            'plataforma' => 'nullable|string|max:100',
            'navegador' => 'nullable|string',
        ]);

        DeviceToken::updateOrCreate(
            ['token' => $request->token],
            [
                'id_usuario' => Auth::id(),
                'id_anexo' => $request->id_anexo,
                'plataforma' => $request->plataforma,
                'navegador' => $request->navegador,
                'estado' => 1,
                'fechaedita' => now(),
                'fechacrea' => now(),
            ]
        );

        return response()->json([
            'ok' => true,
            'message' => 'Token registrado correctamente.'
        ]);
    }
}
