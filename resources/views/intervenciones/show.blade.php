<x-app-layout>
    <x-slot name="header">
        Detalle de intervención
    </x-slot>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="mb-1">
                Intervención sobre {{ $intervencion->dispositivo?->nombre ?? 'dispositivo no disponible' }}
            </h5>
            <p class="text-muted mb-0">
                Información completa de la actuación registrada.
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('intervenciones.edit', $intervencion) }}" class="btn btn-primary-custom">
                <i class="bi bi-pencil me-1"></i> Editar
            </a>

            <a href="{{ route('intervenciones.index') }}" class="btn btn-outline-secondary">
                Volver
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card card-custom">
                <div class="card-body">
                    <h5 class="mb-3">Datos de la intervención</h5>

                    <dl class="row mb-0">
                        <dt class="col-sm-5">Dispositivo</dt>
                        <dd class="col-sm-7">{{ $intervencion->dispositivo?->nombre ?? '—' }}</dd>

                        <dt class="col-sm-5">Cliente</dt>
                        <dd class="col-sm-7">
                            {{ $intervencion->dispositivo?->instalacion?->organizacion?->nombre ?? '—' }}
                        </dd>

                        <dt class="col-sm-5">Instalación</dt>
                        <dd class="col-sm-7">
                            {{ $intervencion->dispositivo?->instalacion?->nombre ?? '—' }}
                        </dd>

                        <dt class="col-sm-5">Tipo</dt>
                        <dd class="col-sm-7">{{ $intervencion->tipo?->nombre ?? '—' }}</dd>

                        <dt class="col-sm-5">Técnico</dt>
                        <dd class="col-sm-7">
                            {{ $intervencion->usuario?->name }}
                            {{ $intervencion->usuario?->apellidos }}
                        </dd>

                        <dt class="col-sm-5">Fecha inicio</dt>
                        <dd class="col-sm-7">
                            {{ $intervencion->fecha_inicio?->format('d/m/Y H:i') ?? '—' }}
                        </dd>

                        <dt class="col-sm-5">Estado intervención</dt>
                        <dd class="col-sm-7">
                            @if($intervencion->estado_intervencion === 'abierta')
                                <span class="badge badge-open">Abierta</span>
                            @else
                                <span class="badge badge-closed">Cerrada</span>
                            @endif
                        </dd>

                        <dt class="col-sm-5">Fecha cierre</dt>
                        <dd class="col-sm-7">
                            {{ $intervencion->fecha_cierre?->format('d/m/Y H:i') ?? '—' }}
                        </dd>

                        <dt class="col-sm-5">Fecha prevista cierre</dt>
                        <dd class="col-sm-7">
                            {{ $intervencion->fecha_prevista_cierre?->format('d/m/Y H:i') ?? '—' }}
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card card-custom mb-4">
                <div class="card-body">
                    <h5 class="mb-3">Cambio de estado</h5>

                    <div class="d-flex align-items-center justify-content-center gap-3 py-3">
                        <div class="text-center">
                            <div class="text-muted small mb-1">Estado anterior</div>
                            <span class="badge text-bg-light border fs-6">
                                {{ $intervencion->estadoAnterior?->nombre ?? '—' }}
                            </span>
                        </div>

                        <i class="bi bi-arrow-right fs-3 text-muted"></i>

                        <div class="text-center">
                            <div class="text-muted small mb-1">Estado nuevo</div>
                            <span class="badge text-bg-light border fs-6">
                                {{ $intervencion->estadoNuevo?->nombre ?? '—' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-custom">
                <div class="card-body">
                    <h5 class="mb-3">Descripción y observaciones</h5>

                    <p>
                        <strong>Descripción:</strong><br>
                        {{ $intervencion->descripcion }}
                    </p>

                    <p class="mb-0">
                        <strong>Observaciones:</strong><br>
                        {{ $intervencion->observaciones ?? 'Sin observaciones registradas.' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
