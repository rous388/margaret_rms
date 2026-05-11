<x-app-layout>
    <x-slot name="header">
        Dispositivos
    </x-slot>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="mb-1">Gestión de dispositivos</h5>
            <p class="text-muted mb-0">
                Administra radares MSSR, PSR y sistemas ADS-B.
            </p>
        </div>

        @if(auth()->user()->rol === 'admin_ansp')
            <a href="{{ route('dispositivos.create') }}" class="btn btn-primary-custom">
                <i class="bi bi-plus-circle me-1"></i> Nuevo dispositivo
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
        </div>
    @endif
    @if(request('estado'))
        <div class="alert alert-info d-flex justify-content-between align-items-center">
            <div>
                <i class="bi bi-funnel me-1"></i>
                Mostrando dispositivos con estado:
                <strong>{{ request('estado') }}</strong>
            </div>

            <a href="{{ route('dispositivos.index') }}" class="btn btn-sm btn-outline-secondary">
                Quitar filtro
            </a>
        </div>
    @endif

    <div class="card card-custom">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Cliente</th>
                        <th>Instalación</th>
                        <th>Estado</th>
                        <th>SAC</th>
                        <th>SIC</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($dispositivos as $dispositivo)
                        <tr>
                            <td><strong>{{ $dispositivo->nombre }}</strong></td>
                            <td>{{ $dispositivo->tipo?->nombre ?? '—' }}</td>
                            <td>{{ $dispositivo->instalacion?->organizacion?->nombre ?? '—' }}</td>
                            <td>{{ $dispositivo->instalacion?->nombre ?? '—' }}</td>
                            <td>
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
                            </td>
                            <td>{{ $dispositivo->codigo_sac ?? '—' }}</td>
                            <td>{{ $dispositivo->codigo_sic ?? '—' }}</td>
                            <td class="text-end">
                                <a href="{{ route('dispositivos.show', $dispositivo) }}"
                                   class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-eye"></i>
                                </a>

                                @if(in_array(auth()->user()->rol, ['admin_ansp', 'tecnico']))
                                    <a href="{{ route('dispositivos.edit', $dispositivo) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                @endif

                                @if(auth()->user()->rol === 'admin_ansp')
                                    <form action="{{ route('dispositivos.destroy', $dispositivo) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('¿Seguro que quieres marcar este dispositivo en mantenimiento?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-tools"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                No hay dispositivos registrados.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $dispositivos->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
