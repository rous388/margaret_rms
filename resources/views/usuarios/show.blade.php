<x-app-layout>
    <x-slot name="header">
        Detalle de usuario
    </x-slot>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="mb-1">{{ $usuario->name }} {{ $usuario->apellidos }}</h5>
            <p class="text-muted mb-0">
                Información de la cuenta de usuario y actividad asociada.
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-primary-custom">
                <i class="bi bi-pencil me-1"></i> Editar
            </a>

            <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">
                Volver
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card card-custom">
                <div class="card-body">
                    <h5 class="mb-3">Datos del usuario</h5>

                    <dl class="row mb-0">
                        <dt class="col-sm-4">Nombre</dt>
                        <dd class="col-sm-8">{{ $usuario->name }} {{ $usuario->apellidos }}</dd>

                        <dt class="col-sm-4">Email</dt>
                        <dd class="col-sm-8">{{ $usuario->email }}</dd>

                        <dt class="col-sm-4">Organización</dt>
                        <dd class="col-sm-8">{{ $usuario->organizacion?->nombre ?? '—' }}</dd>

                        <dt class="col-sm-4">Rol</dt>
                        <dd class="col-sm-8">
                            @php
                                $rolTexto = match($usuario->rol) {
                                    'admin_ansp' => 'Administrador ANSP',
                                    'tecnico' => 'Técnico',
                                    'cliente_visor' => 'Cliente visor',
                                    default => $usuario->rol,
                                };
                            @endphp

                            <span class="badge text-bg-light border">
                                {{ $rolTexto }}
                            </span>
                        </dd>

                        <dt class="col-sm-4">Estado</dt>
                        <dd class="col-sm-8">
                            @if($usuario->estado === 'activo')
                                <span class="badge badge-closed">Activo</span>
                            @else
                                <span class="badge badge-open">Inactivo</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4">Fecha de alta</dt>
                        <dd class="col-sm-8">{{ $usuario->created_at?->format('d/m/Y H:i') }}</dd>

                        <dt class="col-sm-4">Última actualización</dt>
                        <dd class="col-sm-8">{{ $usuario->updated_at?->format('d/m/Y H:i') }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card card-custom">
                <div class="card-body">
                    <h5 class="mb-3">Actividad</h5>

                    <div class="border rounded p-3 mb-3">
                        <h3 class="fw-bold mb-0">{{ $usuario->intervenciones->count() }}</h3>
                        <small class="text-muted">Intervenciones registradas</small>
                    </div>

                    <h6 class="mb-3">Últimas intervenciones</h6>

                    @forelse($usuario->intervenciones->sortByDesc('fecha_inicio')->take(5) as $intervencion)
                        <div class="border-bottom py-2">
                            <div class="fw-semibold">
                                {{ $intervencion->dispositivo?->nombre ?? 'Dispositivo no disponible' }}
                            </div>
                            <small class="text-muted">
                                {{ $intervencion->fecha_inicio?->format('d/m/Y H:i') }}
                            </small>
                        </div>
                    @empty
                        <p class="text-muted mb-0">
                            Este usuario no tiene intervenciones registradas.
                        </p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
