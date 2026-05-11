<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Comprueba que el usuario autenticado tenga uno de los roles permitidos.
     *
     * Ejemplo de uso en rutas:
     * ->middleware('role:admin_ansp,tecnico')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->estado !== 'activo') {
            auth()->logout();

            return redirect()
                ->route('login')
                ->withErrors(['email' => 'Tu usuario está inactivo. Contacta con el administrador.']);
        }

        if (!in_array($user->rol, $roles, true)) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}
