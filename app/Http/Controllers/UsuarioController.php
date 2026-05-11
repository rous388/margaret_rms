<?php

namespace App\Http\Controllers;

use App\Models\Organizacion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::with('organizacion')
            ->orderBy('rol')
            ->orderBy('name')
            ->paginate(10);

        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $organizaciones = Organizacion::where('estado', 'activa')
            ->orderBy('tipo')
            ->orderBy('nombre')
            ->get();

        return view('usuarios.create', compact('organizaciones'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'apellidos' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'organizacion_id' => ['required', 'exists:organizaciones,id'],
            'rol' => ['required', 'in:admin_ansp,tecnico,cliente_visor'],
            'estado' => ['required', 'in:activo,inactivo'],
        ]);

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    public function show(User $usuario)
    {
        $usuario->load(['organizacion', 'intervenciones.dispositivo']);

        return view('usuarios.show', compact('usuario'));
    }

    public function edit(User $usuario)
    {
        $organizaciones = Organizacion::where('estado', 'activa')
            ->orderBy('tipo')
            ->orderBy('nombre')
            ->get();

        return view('usuarios.edit', compact('usuario', 'organizaciones'));
    }

    public function update(Request $request, User $usuario)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'apellidos' => ['nullable', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($usuario->id),
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'organizacion_id' => ['required', 'exists:organizaciones,id'],
            'rol' => ['required', 'in:admin_ansp,tecnico,cliente_visor'],
            'estado' => ['required', 'in:activo,inactivo'],
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $usuario->update($data);

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $usuario)
    {
        if ($usuario->id === auth()->id()) {
            return redirect()
                ->route('usuarios.index')
                ->with('error', 'No puedes desactivar tu propio usuario.');
        }

        $usuario->update([
            'estado' => 'inactivo',
        ]);

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuario desactivado correctamente.');
    }
}
