<?php

namespace App\Http\Controllers;

use App\Models\Organizacion;
use Illuminate\Http\Request;

class OrganizacionController extends Controller
{
    public function index()
    {
        $organizaciones = Organizacion::with('ansp')
            ->orderBy('tipo')
            ->orderBy('nombre')
            ->paginate(10);

        return view('organizaciones.index', compact('organizaciones'));
    }

    public function create()
    {
        $ansps = Organizacion::where('tipo', 'ansp')
            ->where('estado', 'activa')
            ->orderBy('nombre')
            ->get();

        return view('organizaciones.create', compact('ansps'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'tipo' => ['required', 'in:ansp,cliente_final,fabricante,otro'],
            'ansp_id' => ['nullable', 'exists:organizaciones,id'],
            'pais' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'telefono' => ['nullable', 'string', 'max:50'],
            'estado' => ['required', 'in:activa,inactiva'],
            'observaciones' => ['nullable', 'string'],
        ]);

        if ($data['tipo'] === 'ansp') {
            $data['ansp_id'] = null;
        }

        Organizacion::create($data);

        return redirect()
            ->route('organizaciones.index')
            ->with('success', 'Organización creada correctamente.');
    }

    public function show(Organizacion $organizacion)
    {
        $organizacion->load(['ansp', 'clientesFinales', 'usuarios', 'instalaciones']);

        return view('organizaciones.show', compact('organizacion'));
    }

    public function edit(Organizacion $organizacion)
    {
        $ansps = Organizacion::where('tipo', 'ansp')
            ->where('estado', 'activa')
            ->where('id', '!=', $organizacion->id)
            ->orderBy('nombre')
            ->get();

        return view('organizaciones.edit', compact('organizacion', 'ansps'));
    }

    public function update(Request $request, Organizacion $organizacion)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'tipo' => ['required', 'in:ansp,cliente_final,fabricante,otro'],
            'ansp_id' => ['nullable', 'exists:organizaciones,id'],
            'pais' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'telefono' => ['nullable', 'string', 'max:50'],
            'estado' => ['required', 'in:activa,inactiva'],
            'observaciones' => ['nullable', 'string'],
        ]);

        if ($data['tipo'] === 'ansp') {
            $data['ansp_id'] = null;
        }

        $organizacion->update($data);

        return redirect()
            ->route('organizaciones.index')
            ->with('success', 'Organización actualizada correctamente.');
    }

    public function destroy(Organizacion $organizacion)
    {
        $organizacion->update([
            'estado' => 'inactiva',
        ]);

        return redirect()
            ->route('organizaciones.index')
            ->with('success', 'Organización desactivada correctamente.');
    }
}
