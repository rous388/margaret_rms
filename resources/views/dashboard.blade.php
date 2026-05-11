<x-app-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <div class="row g-4 mb-4 row-cols-1 row-cols-md-2 row-cols-xl-5">
        <div class="col">
            <a href="{{ route('dispositivos.index') }}" class="text-decoration-none text-reset">
                <div class="card card-custom card-stat dashboard-card-link h-100">
                    <div class="card-body">
                        <h6 class="text-muted">Total radares</h6>
                        <h2 class="fw-bold">{{ $totalDispositivos }}</h2>
                        <small class="text-muted">Dispositivos registrados</small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col">
            <a href="{{ route('dispositivos.index', ['estado' => 'Operativo']) }}" class="text-decoration-none text-reset">
                <div class="card card-custom card-stat dashboard-card-link h-100">
                    <div class="card-body">
                        <h6 class="text-muted">Operativos</h6>
                        <h2 class="fw-bold">{{ $dispositivosOperativos }}</h2>
                        <small class="text-muted">{{ $porcentajeOperativos }} % del total</small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col">
            <a href="{{ route('dispositivos.index', ['estado' => 'Degradado']) }}" class="text-decoration-none text-reset">
                <div class="card card-custom card-stat dashboard-card-link h-100">
                    <div class="card-body">
                        <h6 class="text-muted">Degradados</h6>
                        <h2 class="fw-bold">{{ $dispositivosDegradados }}</h2>
                        <small class="text-muted">{{ $porcentajeDegradados }} % del total</small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col">
            <a href="{{ route('dispositivos.index', ['estado' => 'En mantenimiento']) }}" class="text-decoration-none text-reset">
                <div class="card card-custom card-stat dashboard-card-link h-100">
                    <div class="card-body">
                        <h6 class="text-muted">En mantenimiento</h6>
                        <h2 class="fw-bold">{{ $dispositivosMantenimiento }}</h2>
                        <small class="text-muted">Pendientes o intervenidos</small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col">
            @if(in_array(auth()->user()->rol, ['admin_ansp', 'tecnico']))
                <a href="{{ route('intervenciones.index', ['estado' => 'abierta']) }}" class="text-decoration-none text-reset">
                    <div class="card card-custom card-stat dashboard-card-link h-100">
                        <div class="card-body">
                            <h6 class="text-muted">Intervenciones abiertas</h6>
                            <h2 class="fw-bold">{{ $intervencionesAbiertas }}</h2>
                            <small class="text-muted">Pendientes de cierre</small>
                        </div>
                    </div>
                </a>
            @else
                <div class="card card-custom card-stat h-100">
                    <div class="card-body">
                        <h6 class="text-muted">Intervenciones abiertas</h6>
                        <h2 class="fw-bold">{{ $intervencionesAbiertas }}</h2>
                        <small class="text-muted">Pendientes de cierre</small>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-5">
            <div class="card card-custom h-100">
                <div class="card-body">
                    <h5 class="mb-3">Dispositivos por estado</h5>

                    <div style="max-width: 240px; margin: 0 auto;">
                        <canvas
                            id="estadoChart"
                            height="170"
                            data-labels='@json($dispositivosPorEstado->keys())'
                            data-values='@json($dispositivosPorEstado->values())'>
                        </canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card card-custom h-100">
                <div class="card-body">
                    <h5 class="mb-3">Distribución técnica</h5>

                    @php
                        $totalTipos = $dispositivosPorTipo->sum();
                    @endphp

                    @forelse($dispositivosPorTipo as $tipo => $total)
                        @php
                            $porcentajeTipo = $totalTipos > 0
                                ? round(($total / $totalTipos) * 100, 1)
                                : 0;
                        @endphp

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div>
                                    <strong>{{ $tipo }}</strong>
                                    <small class="text-muted ms-2">
                                        {{ $total }} {{ $total == 1 ? 'dispositivo' : 'dispositivos' }}
                                    </small>
                                </div>

                                <strong style="color:#00495D;">
                                    {{ $porcentajeTipo }} %
                                </strong>
                            </div>

                            <div class="progress" style="height: 8px; background-color:#DFE0E1;">
                                <div
                                    class="progress-bar progress-bar-tecnica"
                                    role="progressbar"
                                    data-width="{{ $porcentajeTipo }}"
                                    aria-valuenow="{{ $porcentajeTipo }}"
                                    aria-valuemin="0"
                                    aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">
                            No hay dispositivos registrados para mostrar distribución técnica.
                        </p>
                    @endforelse

                    <div class="mt-3 p-3 rounded" style="background-color:#f8f9fa;">
                        <small class="text-muted d-block mb-1">Lectura rápida</small>

                        @if($totalTipos > 0)
                            @php
                                $tipoPredominante = $dispositivosPorTipo->sortDesc()->keys()->first();
                                $totalPredominante = $dispositivosPorTipo->sortDesc()->first();
                            @endphp

                            <span>
                                El tipo predominante es <strong>{{ $tipoPredominante }}</strong>,
                                con {{ $totalPredominante }} {{ $totalPredominante == 1 ? 'dispositivo registrado' : 'dispositivos registrados' }}.
                            </span>
                        @else
                            <span>
                                No existen datos suficientes para calcular la distribución técnica.
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card card-custom">
                <div class="card-body">
                    <h5 class="mb-3">Últimas intervenciones</h5>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Radar</th>
                                <th>Técnico</th>
                                <th>Tipo</th>
                                <th>Estado</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($ultimasIntervenciones as $intervencion)
                                <tr>
                                    <td>{{ $intervencion->fecha_inicio?->format('d/m/Y H:i') }}</td>
                                    <td>{{ $intervencion->dispositivo?->nombre }}</td>
                                    <td>
                                        {{ $intervencion->usuario?->name }}
                                        {{ $intervencion->usuario?->apellidos }}
                                    </td>
                                    <td>{{ $intervencion->tipo?->nombre }}</td>
                                    <td>
                                        @if($intervencion->estado_intervencion === 'abierta')
                                            <span class="badge badge-open">Abierta</span>
                                        @else
                                            <span class="badge badge-closed">Cerrada</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        No hay intervenciones registradas.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card card-custom">
                <div class="card-body">
                    <h5 class="mb-3">Resumen del sistema</h5>

                    <p><strong>Organización:</strong> {{ auth()->user()->organizacion?->nombre ?? 'N/D' }}</p>
                    <p><strong>Rol:</strong> {{ auth()->user()->rol }}</p>
                    <p><strong>Usuarios activos:</strong> {{ $usuariosActivos }}</p>
                    <p><strong>Instalaciones:</strong> {{ $totalInstalaciones }}</p>
                    <p><strong>Dispositivos en mantenimiento:</strong> {{ $dispositivosMantenimiento }}</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const estadoChartElement = document.getElementById('estadoChart');
        const estadoLabels = JSON.parse(estadoChartElement.dataset.labels);
        const estadoData = JSON.parse(estadoChartElement.dataset.values);

        new Chart(estadoChartElement, {
            type: 'doughnut',
            data: {
                labels: estadoLabels,
                datasets: [{
                    data: estadoData,
                    backgroundColor: ['#6AC2C5', '#FBBB21', '#DFE0E1', '#00495D']
                }]
            }
        });

        document.querySelectorAll('.progress-bar-tecnica').forEach((bar) => {
            bar.style.width = `${bar.dataset.width}%`;
            bar.style.backgroundColor = '#6AC2C5';
        });

    </script>
</x-app-layout>
