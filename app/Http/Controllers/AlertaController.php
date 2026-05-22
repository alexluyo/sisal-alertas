<?php

namespace App\Http\Controllers;

use App\Models\Alerta;
use App\Models\Anexo;
use App\Models\TipoAlerta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Services\FirebasePushService;

class AlertaController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();

        $alertasQuery = Alerta::with(['anexo', 'tipo', 'usuario'])
            ->where('estado', 1);

        if (!$usuario->esAdminFull()) {
            $alertasQuery->where(function ($query) use ($usuario) {
                $query->whereNull('id_anexo');

                if ($usuario->id_anexo) {
                    $query->orWhere('id_anexo', $usuario->id_anexo);
                }
            });
        }

        $alertas = $alertasQuery
            ->orderBy('id_alerta', 'desc')
            ->get();

        return view('alertas.index', compact('alertas'));
    }

    public function create()
    {
        $usuario = Auth::user();

        if ($usuario->rol === 'SUBADMIN' && $usuario->id_anexo) {
            $anexos = Anexo::where('id_anexo', $usuario->id_anexo)
                ->where('estado', 1)
                ->get();
        } else {
            $anexos = Anexo::where('estado', 1)->get();
        }

        $tipos = TipoAlerta::where('estado', 1)->get();

        $tipoSeleccionado = request('tipo');

        $titulo = '';
        $mensaje = '';

        switch ((int) $tipoSeleccionado) {

            case 1:
                $titulo = '🚨 ALERTA POR ROBOS';
                $mensaje = "Se reportan posibles robos en la zona.\n".
                           "Se recomienda mantener puertas y ventanas aseguradas.\n".
                           "Evite salir si no es necesario y reporte cualquier actividad sospechosa.";
            break;

            case 2:
                $titulo = '⚠️ PERSONAS SOSPECHOSAS';
                $mensaje = "Se reportan personas sospechosas en la zona.\n".
                           "Se recomienda mantenerse atentos y evitar confrontaciones.\n".
                           "Comunicar cualquier movimiento extraño a las autoridades.";
            break;

            case 3:
                $titulo = '🔎 PERSONA PERDIDA';
                $mensaje = "Se reporta pérdida de niño, adulto mayor o persona vulnerable.\n".
                           "Se solicita apoyo de los vecinos para brindar información.\n".
                           "Ante cualquier dato, comunicarse inmediatamente con las autoridades.";
            break;

            case 4:
                $titulo = '🌧️ ALERTA POR LLUVIAS INTENSAS';
                $mensaje = "Se reportan lluvias intensas en la zona.\n".
                           "Evite transitar por zonas inundables o cercanas a quebradas.\n".
                           "Manténgase atento a los comunicados oficiales.";
            break;

            case 5:
                $titulo = '🚨 ALERTA POR HUAICO';
                $mensaje = "Se reporta posible huaico.\n".
                           "Se recomienda a los vecinos alejarse de quebradas, riachuelos y zonas de riesgo.\n".
                           "Mantenerse atentos a las indicaciones de las autoridades.";
            break;

            case 6:
                $titulo = '🌊 ALERTA POR INUNDACIÓN';
                $mensaje = "Se reporta posible inundación en la zona.\n".
                           "Evite cruzar calles, canales o zonas con acumulación de agua.\n".
                           "Diríjase a zonas seguras si las autoridades lo indican.";
            break;

            case 7:
                $titulo = '⚠️ ALERTA POR SISMO';
                $mensaje = "Se ha reportado un movimiento sísmico.\n".
                           "Mantenga la calma, ubíquese en una zona segura y evite usar ascensores.\n".
                           "Revise posibles daños y siga las indicaciones de las autoridades.";
            break;

            case 8:
                $titulo = '🔥 ALERTA POR INCENDIO FORESTAL';
                $mensaje = "Se reporta incendio forestal en la zona.\n".
                           "Evite acercarse al área afectada y no realice quemas.\n".
                           "Permita el acceso de bomberos y personal de emergencia.";
            break;

            case 9:
                $titulo = '⚠️ ALERTA POR DESLIZAMIENTO';
                $mensaje = "Se reporta posible deslizamiento en la zona.\n".
                           "Evite acercarse a laderas, cerros o zonas inestables.\n".
                           "Diríjase a una zona segura y siga las indicaciones de las autoridades.";
            break;

            case 10:
                $titulo = '🔥 ALERTA DE INCENDIO';
                $mensaje = "Se reporta incendio en la zona.\n".
                           "Evite acercarse al área afectada.\n".
                           "Permita el acceso de bomberos y personal de emergencia.";
            break;

            case 11:
                $titulo = '🚗 ALERTA POR ACCIDENTE DE TRÁNSITO';
                $mensaje = "Se reporta accidente de tránsito en la zona.\n".
                           "Evite transitar por el área afectada.\n".
                           "Permita el paso de ambulancias, bomberos y personal de emergencia.";
            break;
        }

        return view('alertas.create', compact(
            'anexos',
            'tipos',
            'tipoSeleccionado',
            'titulo',
            'mensaje'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_tipo_alerta' => 'required',
            'titulo' => 'required|max:150',
            'mensaje' => 'required',
            'evidencia' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $rutaEvidencia = null;

        if ($request->hasFile('evidencia')) {
            $rutaEvidencia = $request->file('evidencia')
                ->store('evidencias', 'public');
        }

        $usuario = Auth::user();

        $idAnexo = $request->id_anexo;

        if ($usuario->rol === 'SUBADMIN' && $usuario->id_anexo) {
            $idAnexo = $usuario->id_anexo;
        }

        Alerta::create([
            'id_tipo_alerta' => $request->id_tipo_alerta,
            'titulo' => $request->titulo,
            'mensaje' => $request->mensaje,
            'evidencia' => $rutaEvidencia,
            'id_anexo' => $idAnexo,
            'id_usuario' => Auth::id(),
            'estado' => 1,
            'fecha_envio' => now(),
            'fechacrea' => now()
        ]);

        app(FirebasePushService::class)->enviarPorAnexo(
            $request->titulo,
            $request->mensaje,
            route('alertas.index'),
            $idAnexo
        );

        return redirect()
            ->route('alertas.index')
            ->with('success', 'Alerta registrada correctamente.');
    }

    public function eliminar(Alerta $alerta)
    {
        $alerta->update([
            'estado' => 0,
            'fechaelimina' => now()
        ]);

        return redirect()
            ->route('alertas.index')
            ->with('success', 'Alerta eliminada.');
    }
}
