<x-app-layout>
    <x-slot name="header">
        Detalle de organización
    </x-slot>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="mb-1">{{ $organizacion->nombre }}</h5>
            <p class="text-muted mb-0">
                Información general de la organización seleccionada.
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('organizaciones.edit', $organizacion) }}" class="btn btn-primary-custom">
                <i class="bi bi-pencil me-1"></i> Editar
            </a>

            <a href="{{ route('organizaciones.index') }}" class="btn btn-outline-secondary">
                Volver
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card card-custom">
                <div class="card-body">
                    <h5 class="mb-3">Datos generales</h5>

                    <dl class="row mb-0">
                        <dt class="col-sm-4">Nombre</dt>
                        <dd class="col-sm-8">{{ $organizacion->nombre }}</dd>

                        <dt class="col-sm-4">Tipo</dt>
                        <dd class="col-sm-8">
                            <span class="badge text-bg-light border">
                                {{ str_replace('_', ' ', ucfirst($organizacion->tipo)) }}
                            </span>
                        </dd>

                        <dt class="col-sm-4">ANSP asociado</dt>
                        <dd class="col-sm-8">{{ $organizacion->ansp?->nombre ?? 'No aplica' }}</dd>

                        <dt class="col-sm-4">País</dt>
                        <dd class="col-sm-8">{{ $organizacion->pais ?? '—' }}</dd>

                        <dt class="col-sm-4">Email</dt>
                        <dd class="col-sm-8">{{ $organizacion->email ?? '—' }}</dd>

                        <dt class="col-sm-4">Teléfono</dt>
                        <dd class="col-sm-8">{{ $organizacion->telefono ?? '—' }}</dd>

                        <dt class="col-sm-4">Estado</dt>
                        <dd class="col-sm-8">
                            @if($organizacion->estado === 'activa')
                                <span class="badge badge-closed">Activa</span>
                            @else
                                <span class="badge badge-open">Inactiva</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4">Observaciones</dt>
                        <dd class="col-sm-8">{{ $organizacion->observaciones ?? '—' }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card card-custom mb-4">
                <div class="card-body">
                    <h5 class="mb-3">Resumen</h5>

                    <div class="row text-center">
                        <div class="col-4">
                            <div class="border rounded p-3">
                                <h4 class="fw-bold mb-0">{{ $organizacion->usuarios->count() }}</h4>
                                <small class="text-muted">Usuarios</small>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="border rounded p-3">
                                <h4 class="fw-bold mb-0">{{ $organizacion->instalaciones->count() }}</h4>
                                <small class="text-muted">Instalaciones</small>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="border rounded p-3">
                                <h4 class="fw-bold mb-0">{{ $organizacion->clientesFinales->count() }}</h4>
                                <small class="text-muted">Clientes</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($organizacion->tipo === 'ansp')
                <div class="card card-custom">
                    <div class="card-body">
                        <h5 class="mb-3">Clientes finales asociados</h5>

                        @forelse($organizacion->clientesFinales as $cliente)
                            <div class="d-flex justify-content-between border-bottom py-2">
                                <span>{{ $cliente->nombre }}</span>
                                <span class="text-muted">{{ $cliente->pais ?? '—' }}</span>
                            </div>
                        @empty
                            <p class="text-muted mb-0">No hay clientes finales asociados.</p>
                        @endforelse
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
