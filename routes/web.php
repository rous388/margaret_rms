<?php

use App\Http\Controllers\IntervencionController;
use App\Http\Controllers\DispositivoController;
use App\Http\Controllers\InstalacionController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\OrganizacionController;
use App\Http\Controllers\ProfileController;
use App\Models\Dispositivo;
use App\Models\EstadoDispositivo;
use App\Models\Instalacion;
use App\Models\Intervencion;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        $user = auth()->user();

        $queryDispositivos = Dispositivo::query()
            ->with(['instalacion.organizacion', 'estado', 'tipo']);

        $queryIntervenciones = Intervencion::query()
            ->with(['dispositivo', 'usuario', 'tipo']);

        $queryInstalaciones = Instalacion::query();
        $queryUsuarios = User::query()->where('estado', 'activo');

        if ($user->rol === 'cliente_visor') {
            $organizacionId = $user->organizacion_id;

            $queryInstalaciones->where('organizacion_id', $organizacionId);

            $queryDispositivos->whereHas('instalacion', function ($q) use ($organizacionId) {
                $q->where('organizacion_id', $organizacionId);
            });

            $queryIntervenciones->whereHas('dispositivo.instalacion', function ($q) use ($organizacionId) {
                $q->where('organizacion_id', $organizacionId);
            });

            $queryUsuarios->where('organizacion_id', $organizacionId);
        }

        if ($user->rol === 'tecnico') {
            $organizacionId = $user->organizacion_id;
            $queryUsuarios->where('organizacion_id', $organizacionId);
        }

        $estadoOperativo = EstadoDispositivo::where('nombre', 'Operativo')->first();
        $estadoMantenimiento = EstadoDispositivo::where('nombre', 'En mantenimiento')->first();
        $estadoDegradado = EstadoDispositivo::where('nombre', 'Degradado')->first();
        $dispositivosPorEstado = (clone $queryDispositivos)
            ->join('estados_dispositivo', 'dispositivos.estado_dispositivo_id', '=', 'estados_dispositivo.id')
            ->selectRaw('estados_dispositivo.nombre as estado, COUNT(*) as total')
            ->groupBy('estados_dispositivo.nombre')
            ->pluck('total', 'estado');

        $dispositivosPorTipo = (clone $queryDispositivos)
            ->join('tipos_dispositivo', 'dispositivos.tipo_dispositivo_id', '=', 'tipos_dispositivo.id')
            ->selectRaw('tipos_dispositivo.nombre as tipo, COUNT(*) as total')
            ->groupBy('tipos_dispositivo.nombre')
            ->pluck('total', 'tipo');

        $totalDispositivos = (clone $queryDispositivos)->count();

        $porcentajeOperativos = $totalDispositivos > 0
            ? round(((clone $queryDispositivos)->where('estado_dispositivo_id', $estadoOperativo?->id)->count() / $totalDispositivos) * 100, 1)
            : 0;

        $porcentajeDegradados = $totalDispositivos > 0
            ? round(((clone $queryDispositivos)->where('estado_dispositivo_id', $estadoDegradado?->id)->count() / $totalDispositivos) * 100, 1)
            : 0;
        return view('dashboard', [
            'totalDispositivos' => $totalDispositivos,
            'porcentajeOperativos' => $porcentajeOperativos,
            'porcentajeDegradados' => $porcentajeDegradados,
            'dispositivosPorEstado' => $dispositivosPorEstado,
            'dispositivosPorTipo' => $dispositivosPorTipo,
            'dispositivosOperativos' => $estadoOperativo
                ? (clone $queryDispositivos)->where('estado_dispositivo_id', $estadoOperativo->id)->count()
                : 0,
            'dispositivosMantenimiento' => $estadoMantenimiento
                ? (clone $queryDispositivos)->where('estado_dispositivo_id', $estadoMantenimiento->id)->count()
                : 0,
            'dispositivosDegradados' => $estadoDegradado
                ? (clone $queryDispositivos)->where('estado_dispositivo_id', $estadoDegradado->id)->count()
                : 0,
            'intervencionesAbiertas' => (clone $queryIntervenciones)->where('estado_intervencion', 'abierta')->count(),
            'ultimasIntervenciones' => (clone $queryIntervenciones)->latest('fecha_inicio')->take(5)->get(),
            'usuariosActivos' => (clone $queryUsuarios)->count(),
            'totalInstalaciones' => (clone $queryInstalaciones)->count(),
        ]);
    })->name('dashboard');

    Route::resource('organizaciones', OrganizacionController::class)
        ->parameters([
            'organizaciones' => 'organizacion',
        ])
        ->middleware('role:admin_ansp');

    Route::resource('usuarios', UsuarioController::class)
        ->parameters([
            'usuarios' => 'usuario',
        ])
        ->middleware('role:admin_ansp');

    Route::resource('instalaciones', InstalacionController::class)
        ->parameters([
            'instalaciones' => 'instalacion',
        ])
        ->middleware('role:admin_ansp');

    Route::get('/dispositivos/{dispositivo}/pdf', [DispositivoController::class, 'pdf'])
        ->name('dispositivos.pdf')
        ->middleware('role:admin_ansp,tecnico,cliente_visor');

    Route::resource('dispositivos', DispositivoController::class)
        ->parameters([
            'dispositivos' => 'dispositivo',
        ])
        ->middleware('role:admin_ansp,tecnico,cliente_visor');

    Route::resource('intervenciones', IntervencionController::class)
        ->parameters([
            'intervenciones' => 'intervencion',
        ])
        ->middleware('role:admin_ansp,tecnico');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
