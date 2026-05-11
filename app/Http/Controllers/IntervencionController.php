<?php

namespace App\Http\Controllers;

use App\Models\Dispositivo;
use App\Models\EstadoDispositivo;
use App\Models\Intervencion;
use App\Models\TipoIntervencion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IntervencionController extends Controller
{
    public function index(Request $request)
    {
        $query = Intervencion::with([
                'dispositivo.instalacion.organizacion',
                'usuario',
                'tipo',
                'estadoAnterior',
                'estadoNuevo',
            ])
            ->latest('fecha_inicio');

        if ($request->filled('estado')) {
            $query->where('estado_intervencion', $request->estado);
        }

        $intervenciones = $query->paginate(10)->withQueryString();

        return view('intervenciones.index', compact('intervenciones'));
    }

    public function create(Request $request)
    {
        $dispositivos = Dispositivo::with(['instalacion.organizacion', 'estado'])
            ->orderBy('nombre')
            ->get();

        $tipos = TipoIntervencion::orderBy('nombre')->get();
        $estados = EstadoDispositivo::orderBy('nombre')->get();

        $dispositivoSeleccionado = null;

        if ($request->filled('dispositivo_id')) {
            $dispositivoSeleccionado = Dispositivo::with('estado')
                ->find($request->input('dispositivo_id'));
        }

        return view('intervenciones.create', compact(
            'dispositivos',
            'tipos',
            'estados',
            'dispositivoSeleccionado'
        ));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Debes iniciar sesión para registrar una intervención.');
        }

        $data = $request->validate([
            'dispositivo_id' => ['required', 'exists:dispositivos,id'],
            'tipo_intervencion_id' => ['required', 'exists:tipos_intervencion,id'],
            'fecha_inicio' => ['required', 'date'],
            'descripcion' => ['required', 'string'],
            'estado_anterior_id' => ['nullable', 'exists:estados_dispositivo,id'],
            'estado_nuevo_id' => ['nullable', 'exists:estados_dispositivo,id'],
            'estado_intervencion' => ['required', 'in:abierta,cerrada'],
            'fecha_cierre' => ['nullable', 'date', 'required_if:estado_intervencion,cerrada'],
            'fecha_prevista_cierre' => ['nullable', 'date', 'required_if:estado_intervencion,abierta'],
            'observaciones' => ['nullable', 'string'],
        ]);

        $data['usuario_id'] = Auth::id();

        $intervencion = Intervencion::create($data);

        if (!empty($data['estado_nuevo_id'])) {
            $intervencion->dispositivo->update([
                'estado_dispositivo_id' => $data['estado_nuevo_id'],
            ]);
        }

        return redirect()
            ->route('dispositivos.show', $intervencion->dispositivo)
            ->with('success', 'Intervención registrada correctamente.');
    }

    public function show(Intervencion $intervencion)
    {
        $intervencion->load([
            'dispositivo.instalacion.organizacion',
            'usuario',
            'tipo',
            'estadoAnterior',
            'estadoNuevo',
        ]);

        return view('intervenciones.show', compact('intervencion'));
    }

    public function edit(Intervencion $intervencion)
    {
        $intervencion->load('dispositivo');

        $dispositivos = Dispositivo::with(['instalacion.organizacion', 'estado'])
            ->orderBy('nombre')
            ->get();

        $tipos = TipoIntervencion::orderBy('nombre')->get();
        $estados = EstadoDispositivo::orderBy('nombre')->get();

        return view('intervenciones.edit', compact(
            'intervencion',
            'dispositivos',
            'tipos',
            'estados'
        ));
    }

    public function update(Request $request, Intervencion $intervencion)
    {
        $data = $request->validate([
            'dispositivo_id' => ['required', 'exists:dispositivos,id'],
            'tipo_intervencion_id' => ['required', 'exists:tipos_intervencion,id'],
            'fecha_inicio' => ['required', 'date'],
            'descripcion' => ['required', 'string'],
            'estado_anterior_id' => ['nullable', 'exists:estados_dispositivo,id'],
            'estado_nuevo_id' => ['nullable', 'exists:estados_dispositivo,id'],
            'estado_intervencion' => ['required', 'in:abierta,cerrada'],
            'fecha_cierre' => ['nullable', 'date', 'required_if:estado_intervencion,cerrada'],
            'fecha_prevista_cierre' => ['nullable', 'date', 'required_if:estado_intervencion,abierta'],
            'observaciones' => ['nullable', 'string'],
        ]);

        $intervencion->update($data);

        if (!empty($data['estado_nuevo_id'])) {
            $intervencion->dispositivo->update([
                'estado_dispositivo_id' => $data['estado_nuevo_id'],
            ]);
        }

        return redirect()
            ->route('intervenciones.show', $intervencion)
            ->with('success', 'Intervención actualizada correctamente.');
    }

    public function destroy(Intervencion $intervencion)
    {
        $intervencion->delete();

        return redirect()
            ->route('intervenciones.index')
            ->with('success', 'Intervención eliminada correctamente.');
    }
}
