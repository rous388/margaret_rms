<?php

namespace App\Http\Controllers;

use App\Models\Dispositivo;
use App\Models\EstadoDispositivo;
use App\Models\Instalacion;
use App\Models\TipoDispositivo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DispositivoController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Dispositivo::with(['instalacion.organizacion', 'tipo', 'estado'])
            ->orderBy('nombre');

        if ($user->rol === 'cliente_visor') {
            $query->whereHas('instalacion', function ($q) use ($user) {
                $q->where('organizacion_id', $user->organizacion_id);
            });
        }

        if ($request->filled('estado')) {
            $query->whereHas('estado', function ($q) use ($request) {
                $q->where('nombre', $request->estado);
            });
        }

        $dispositivos = $query->paginate(10)->withQueryString();

        return view('dispositivos.index', compact('dispositivos'));
    }

    public function create()
    {
        $user = Auth::user();

        if ($user->rol !== 'admin_ansp') {
            abort(403, 'No tienes permisos para crear dispositivos.');
        }

        $instalaciones = Instalacion::with('organizacion')
            ->orderBy('nombre')
            ->get();

        $tipos = TipoDispositivo::orderBy('nombre')->get();
        $estados = EstadoDispositivo::orderBy('nombre')->get();

        return view('dispositivos.create', compact('instalaciones', 'tipos', 'estados'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->rol !== 'admin_ansp') {
            abort(403, 'No tienes permisos para crear dispositivos.');
        }

        $data = $request->validate([
            'instalacion_id' => ['required', 'exists:instalaciones,id'],
            'tipo_dispositivo_id' => ['required', 'exists:tipos_dispositivo,id'],
            'estado_dispositivo_id' => ['required', 'exists:estados_dispositivo,id'],
            'nombre' => ['required', 'string', 'max:255'],
            'codigo_sac' => ['nullable', 'string', 'max:50'],
            'codigo_sic' => ['nullable', 'string', 'max:50'],
            'coordenadas' => ['nullable', 'string', 'max:255'],
            'altura_antena' => ['nullable', 'numeric', 'min:0'],
            'tiempo_vuelta' => ['nullable', 'numeric', 'min:0'],
            'fecha_instalacion' => ['nullable', 'date'],
            'observaciones' => ['nullable', 'string'],
        ]);

        Dispositivo::create($data);

        return redirect()
            ->route('dispositivos.index')
            ->with('success', 'Dispositivo creado correctamente.');
    }

    public function show(Dispositivo $dispositivo)
    {
        $user = Auth::user();

        $dispositivo->load([
            'instalacion.organizacion',
            'tipo',
            'estado',
            'intervenciones.usuario',
            'intervenciones.tipo',
            'intervenciones.estadoAnterior',
            'intervenciones.estadoNuevo',
        ]);

        if (
            $user->rol === 'cliente_visor'
            && $dispositivo->instalacion?->organizacion_id !== $user->organizacion_id
        ) {
            abort(403, 'No tienes permisos para ver este dispositivo.');
        }

        return view('dispositivos.show', compact('dispositivo'));
    }

    public function edit(Dispositivo $dispositivo)
    {
        $user = Auth::user();

        if (!in_array($user->rol, ['admin_ansp', 'tecnico'])) {
            abort(403, 'No tienes permisos para editar dispositivos.');
        }

        $instalaciones = Instalacion::with('organizacion')
            ->orderBy('nombre')
            ->get();

        $tipos = TipoDispositivo::orderBy('nombre')->get();
        $estados = EstadoDispositivo::orderBy('nombre')->get();

        return view('dispositivos.edit', compact('dispositivo', 'instalaciones', 'tipos', 'estados'));
    }

    public function update(Request $request, Dispositivo $dispositivo)
    {
        $user = Auth::user();

        if (!in_array($user->rol, ['admin_ansp', 'tecnico'])) {
            abort(403, 'No tienes permisos para editar dispositivos.');
        }

        $data = $request->validate([
            'instalacion_id' => ['required', 'exists:instalaciones,id'],
            'tipo_dispositivo_id' => ['required', 'exists:tipos_dispositivo,id'],
            'estado_dispositivo_id' => ['required', 'exists:estados_dispositivo,id'],
            'nombre' => ['required', 'string', 'max:255'],
            'codigo_sac' => ['nullable', 'string', 'max:50'],
            'codigo_sic' => ['nullable', 'string', 'max:50'],
            'coordenadas' => ['nullable', 'string', 'max:255'],
            'altura_antena' => ['nullable', 'numeric', 'min:0'],
            'tiempo_vuelta' => ['nullable', 'numeric', 'min:0'],
            'fecha_instalacion' => ['nullable', 'date'],
            'observaciones' => ['nullable', 'string'],
        ]);

        $dispositivo->update($data);

        return redirect()
            ->route('dispositivos.index')
            ->with('success', 'Dispositivo actualizado correctamente.');
    }

    public function destroy(Dispositivo $dispositivo)
    {
        $user = Auth::user();

        if ($user->rol !== 'admin_ansp') {
            abort(403, 'No tienes permisos para modificar este dispositivo.');
        }

        $estadoMantenimiento = EstadoDispositivo::where('nombre', 'En mantenimiento')->first();

        if ($estadoMantenimiento) {
            $dispositivo->update([
                'estado_dispositivo_id' => $estadoMantenimiento->id,
            ]);
        }

        return redirect()
            ->route('dispositivos.index')
            ->with('success', 'Dispositivo marcado como en mantenimiento.');
    }

    public function pdf(Dispositivo $dispositivo)
    {
        $user = Auth::user();

        $dispositivo->load([
            'instalacion.organizacion',
            'tipo',
            'estado',
            'intervenciones.usuario',
            'intervenciones.tipo',
            'intervenciones.estadoAnterior',
            'intervenciones.estadoNuevo',
        ]);

        if (
            $user->rol === 'cliente_visor'
            && $dispositivo->instalacion?->organizacion_id !== $user->organizacion_id
        ) {
            abort(403, 'No tienes permisos para generar este informe.');
        }

        $pdf = Pdf::loadView('pdf.dispositivo-trazabilidad', [
            'dispositivo' => $dispositivo,
            'fechaGeneracion' => now(),
        ]);

        $nombreArchivo = 'trazabilidad_' . str_replace(' ', '_', strtolower($dispositivo->nombre)) . '.pdf';

        return $pdf->download($nombreArchivo);
    }
}
