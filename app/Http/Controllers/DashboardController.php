<?php

namespace App\Http\Controllers;

use App\Models\Alerta;
use App\Models\Anexo;
use App\Models\Vecino;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();

        $totalVecinos = Vecino::where('estado', 1)->count();
        $totalAnexos = Anexo::where('estado', 1)->count();

        $alertasQuery = Alerta::with(['tipo', 'anexo'])
            ->where('estado', 1);

        if (!$usuario->esAdminFull()) {

            $alertasQuery->where(function ($query) use ($usuario) {

                $query->whereNull('id_anexo');

                if ($usuario->id_anexo) {
                    $query->orWhere('id_anexo', $usuario->id_anexo);
                }

            });
        }

        $totalAlertas = (clone $alertasQuery)->count();

        $alertasRecientes = $alertasQuery
            ->orderBy('id_alerta', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalVecinos',
            'totalAnexos',
            'totalAlertas',
            'alertasRecientes'
        ));
    }
}
