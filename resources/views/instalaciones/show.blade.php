<x-app-layout>
    <x-slot name="header">
        Detalle de instalación
    </x-slot>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="mb-1">{{ $instalacion->nombre }}</h5>
            <p class="text-muted mb-0">
                Información general del emplazamiento y dispositivos asociados.
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('instalaciones.edit', $instalacion) }}" class="btn btn-primary-custom">
                <i class="bi bi-pencil me-1"></i> Editar
            </a>

            <a href="{{ route('instalaciones.index') }}" class="btn btn-outline-secondary">
                Volver
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card card-custom">
                <div class="card-body">
                    <h5 class="mb-3">Datos de la instalación</h5>

                    <dl class="row mb-0">
                        <dt class="col-sm-5">Nombre</dt>
                        <dd class="col-sm-7">{{ $instalacion->nombre }}</dd>

                        <dt class="col-sm-5">Cliente</dt>
                        <dd class="col-sm-7">{{ $instalacion->organizacion?->nombre ?? '—' }}</dd>

                        <dt class="col-sm-5">País</dt>
                        <dd class="col-sm-7">{{ $instalacion->pais ?? '—' }}</dd>

                        <dt class="col-sm-5">Ciudad/Zona</dt>
                        <dd class="col-sm-7">{{ $instalacion->ciudad_zona ?? '—' }}</dd>

                        <dt class="col-sm-5">Coordenadas</dt>
                        <dd class="col-sm-7">{{ $instalacion->coordenadas ?? '—' }}</dd>

                        <dt class="col-sm-5">Estado</dt>
                        <dd class="col-sm-7">
                            @if($instalacion->estado === 'activa')
                                <span class="badge badge-closed">Activa</span>
                            @elseif($instalacion->estado === 'mantenimiento')
                                <span class="badge badge-open">En mantenimiento</span>
                            @else
                                <span class="badge text-bg-secondary">Inactiva</span>
                            @endif
                        </dd>

                        <dt class="col-sm-5">Observaciones</dt>
                        <dd class="col-sm-7">{{ $instalacion->observaciones ?? '—' }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card card-custom">
                <div class="card-body">
                    <h5 class="mb-3">Dispositivos asociados</h5>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Tipo</th>
                                <th>Estado</th>
                                <th>SAC</th>
                                <th>SIC</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($instalacion->dispositivos as $dispositivo)
                                <tr>
                                    <td><strong>{{ $dispositivo->nombre }}</strong></td>
                                    <td>{{ $dispositivo->tipo?->nombre ?? '—' }}</td>
                                    <td>{{ $dispositivo->estado?->nombre ?? '—' }}</td>
                                    <td>{{ $dispositivo->codigo_sac ?? '—' }}</td>
                                    <td>{{ $dispositivo->codigo_sic ?? '—' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        Esta instalación todavía no tiene dispositivos asociados.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
