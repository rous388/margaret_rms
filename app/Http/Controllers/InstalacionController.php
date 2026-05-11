<?php

namespace App\Http\Controllers;

use App\Models\Instalacion;
use App\Models\Organizacion;
use Illuminate\Http\Request;

class InstalacionController extends Controller
{
    public function index()
    {
        $instalaciones = Instalacion::with('organizacion')
            ->orderBy('nombre')
            ->paginate(10);

        return view('instalaciones.index', compact('instalaciones'));
    }

    public function create()
    {
        $clientes = Organizacion::where('tipo', 'cliente_final')
            ->where('estado', 'activa')
            ->orderBy('nombre')
            ->get();

        return view('instalaciones.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'organizacion_id' => ['required', 'exists:organizaciones,id'],
            'nombre' => ['required', 'string', 'max:255'],
            'pais' => ['nullable', 'string', 'max:255'],
            'ciudad_zona' => ['nullable', 'string', 'max:255'],
            'coordenadas' => ['nullable', 'string', 'max:255'],
            'estado' => ['required', 'in:activa,inactiva,mantenimiento'],
            'observaciones' => ['nullable', 'string'],
        ]);

        Instalacion::create($data);

        return redirect()
            ->route('instalaciones.index')
            ->with('success', 'Instalación creada correctamente.');
    }

    public function show(Instalacion $instalacion)
    {
        $instalacion->load(['organizacion', 'dispositivos.tipo', 'dispositivos.estado']);

        return view('instalaciones.show', compact('instalacion'));
    }

    public function edit(Instalacion $instalacion)
    {
        $clientes = Organizacion::where('tipo', 'cliente_final')
            ->where('estado', 'activa')
            ->orderBy('nombre')
            ->get();

        return view('instalaciones.edit', compact('instalacion', 'clientes'));
    }

    public function update(Request $request, Instalacion $instalacion)
    {
        $data = $request->validate([
            'organizacion_id' => ['required', 'exists:organizaciones,id'],
            'nombre' => ['required', 'string', 'max:255'],
            'pais' => ['nullable', 'string', 'max:255'],
            'ciudad_zona' => ['nullable', 'string', 'max:255'],
            'coordenadas' => ['nullable', 'string', 'max:255'],
            'estado' => ['required', 'in:activa,inactiva,mantenimiento'],
            'observaciones' => ['nullable', 'string'],
        ]);

        $instalacion->update($data);

        return redirect()
            ->route('instalaciones.index')
            ->with('success', 'Instalación actualizada correctamente.');
    }

    public function destroy(Instalacion $instalacion)
    {
        $instalacion->update([
            'estado' => 'inactiva',
        ]);

        return redirect()
            ->route('instalaciones.index')
            ->with('success', 'Instalación desactivada correctamente.');
    }
}
