<x-app-layout>
    <x-slot name="header">
        Detalle de dispositivo
    </x-slot>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="mb-1">{{ $dispositivo->nombre }}</h5>
            <p class="text-muted mb-0">
                Ficha técnica del radar y trazabilidad de intervenciones.
            </p>
        </div>

        <div class="d-flex gap-2">
            @if(in_array(auth()->user()->rol, ['admin_ansp', 'tecnico']))
                <a href="{{ route('dispositivos.edit', $dispositivo) }}" class="btn btn-primary-custom">
                    <i class="bi bi-pencil me-1"></i> Editar
                </a>
            @endif

            <a href="{{ route('dispositivos.index') }}" class="btn btn-outline-secondary">
                Volver
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card card-custom mb-4">
                <div class="card-body">
                    <h5 class="mb-3">Datos generales</h5>

                    <dl class="row mb-0">
                        <dt class="col-sm-5">Nombre</dt>
                        <dd class="col-sm-7">{{ $dispositivo->nombre }}</dd>

                        <dt class="col-sm-5">Tipo</dt>
                        <dd class="col-sm-7">{{ $dispositivo->tipo?->nombre ?? '—' }}</dd>

                        <dt class="col-sm-5">Estado actual</dt>
                        <dd class="col-sm-7">
                            @php
                                $estado = $dispositivo->estado?->nombre;
                            @endphp

                            @if($estado === 'Operativo')
                                <span class="badge badge-closed">Operativo</span>
                            @elseif($estado === 'Degradado')
                                <span class="badge badge-open">Degradado</span>
                            @elseif($estado === 'En mantenimiento')
                                <span class="badge text-bg-info">En mantenimiento</span>
                            @else
                                <span class="badge text-bg-secondary">{{ $estado ?? '—' }}</span>
                            @endif
                        </dd>

                        <dt class="col-sm-5">Cliente</dt>
                        <dd class="col-sm-7">{{ $dispositivo->instalacion?->organizacion?->nombre ?? '—' }}</dd>

                        <dt class="col-sm-5">Instalación</dt>
                        <dd class="col-sm-7">{{ $dispositivo->instalacion?->nombre ?? '—' }}</dd>

                        <dt class="col-sm-5">Fecha instalación</dt>
                        <dd class="col-sm-7">
                            {{ $dispositivo->fecha_instalacion?->format('d/m/Y') ?? '—' }}
                        </dd>
                    </dl>
                </div>
            </div>

            <div class="card card-custom">
                <div class="card-body">
                    <h5 class="mb-3">Datos técnicos</h5>

                    <dl class="row mb-0">
                        <dt class="col-sm-5">SAC</dt>
                        <dd class="col-sm-7">{{ $dispositivo->codigo_sac ?? '—' }}</dd>

                        <dt class="col-sm-5">SIC</dt>
                        <dd class="col-sm-7">{{ $dispositivo->codigo_sic ?? '—' }}</dd>

                        <dt class="col-sm-5">Coordenadas</dt>
                        <dd class="col-sm-7">{{ $dispositivo->coordenadas ?? '—' }}</dd>

                        <dt class="col-sm-5">Altura antena</dt>
                        <dd class="col-sm-7">
                            {{ $dispositivo->altura_antena !== null ? $dispositivo->altura_antena . ' m' : '—' }}
                        </dd>

                        <dt class="col-sm-5">Tiempo vuelta</dt>
                        <dd class="col-sm-7">
                            {{ $dispositivo->tiempo_vuelta !== null ? $dispositivo->tiempo_vuelta . ' s' : '—' }}
                        </dd>

                        <dt class="col-sm-5">Observaciones</dt>
                        <dd class="col-sm-7">{{ $dispositivo->observaciones ?? '—' }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card card-custom">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Historial de intervenciones</h5>

                        @if(in_array(auth()->user()->rol, ['admin_ansp', 'tecnico']))
                            <a href="{{ route('intervenciones.create', ['dispositivo_id' => $dispositivo->id]) }}"
                                class="btn btn-sm btn-primary-custom">
                                 <i class="bi bi-plus-circle me-1"></i> Registrar intervención
                            </a>
                        @endif
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Tipo</th>
                                <th>Técnico</th>
                                <th>Estado</th>
                                <th>Cambio estado</th>
                            </tr>
                            </thead>

                            <tbody>
                            @forelse($dispositivo->intervenciones->sortByDesc('fecha_inicio') as $intervencion)
                                <tr>
                                    <td>{{ $intervencion->fecha_inicio?->format('d/m/Y H:i') }}</td>
                                    <td>{{ $intervencion->tipo?->nombre ?? '—' }}</td>
                                    <td>
                                        {{ $intervencion->usuario?->name }}
                                        {{ $intervencion->usuario?->apellidos }}
                                    </td>
                                    <td>
                                        @if($intervencion->estado_intervencion === 'abierta')
                                            <span class="badge badge-open">Abierta</span>
                                            @if($intervencion->fecha_prevista_cierre)
                                                <br>
                                                <small class="text-muted">
                                                    Prevista: {{ $intervencion->fecha_prevista_cierre->format('d/m/Y') }}
                                                </small>
                                            @endif
                                        @else
                                            <span class="badge badge-closed">Cerrada</span>
                                            @if($intervencion->fecha_cierre)
                                                <br>
                                                <small class="text-muted">
                                                    Cierre: {{ $intervencion->fecha_cierre->format('d/m/Y') }}
                                                </small>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        {{ $intervencion->estadoAnterior?->nombre ?? '—' }}
                                        <i class="bi bi-arrow-right mx-1"></i>
                                        {{ $intervencion->estadoNuevo?->nombre ?? '—' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="5" class="bg-light">
                                        <small>
                                            <strong>Descripción:</strong>
                                            {{ $intervencion->descripcion }}
                                            @if($intervencion->observaciones)
                                                <br>
                                                <strong>Observaciones:</strong>
                                                {{ $intervencion->observaciones }}
                                            @endif
                                        </small>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        Este dispositivo todavía no tiene intervenciones registradas.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 d-flex justify-content-end">
                        <a href="{{ route('dispositivos.pdf', $dispositivo) }}" class="btn btn-outline-secondary">
                            <i class="bi bi-file-earmark-pdf me-1"></i> Generar informe PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
