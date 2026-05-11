<x-app-layout>
    <x-slot name="header">
        Intervenciones
    </x-slot>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="mb-1">Gestión de intervenciones</h5>
            <p class="text-muted mb-0">
                Consulta y registra actuaciones realizadas sobre los radares.
            </p>
        </div>

        <a href="{{ route('intervenciones.create') }}" class="btn btn-primary-custom">
            <i class="bi bi-plus-circle me-1"></i> Nueva intervención
        </a>
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
                Mostrando intervenciones con estado:
                <strong>{{ ucfirst(request('estado')) }}</strong>
            </div>

            <a href="{{ route('intervenciones.index') }}" class="btn btn-sm btn-outline-secondary">
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
                        <th>Fecha</th>
                        <th>Dispositivo</th>
                        <th>Cliente</th>
                        <th>Tipo</th>
                        <th>Técnico</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($intervenciones as $intervencion)
                        <tr>
                            <td>{{ $intervencion->fecha_inicio?->format('d/m/Y H:i') }}</td>
                            <td>
                                <strong>{{ $intervencion->dispositivo?->nombre ?? '—' }}</strong>
                                <br>
                                <small class="text-muted">
                                    {{ $intervencion->dispositivo?->instalacion?->nombre ?? '—' }}
                                </small>
                            </td>
                            <td>
                                {{ $intervencion->dispositivo?->instalacion?->organizacion?->nombre ?? '—' }}
                            </td>
                            <td>{{ $intervencion->tipo?->nombre ?? '—' }}</td>
                            <td>
                                {{ $intervencion->usuario?->name }}
                                {{ $intervencion->usuario?->apellidos }}
                            </td>
                            <td>
                                @if($intervencion->estado_intervencion === 'abierta')
                                    <span class="badge badge-open">Abierta</span>
                                @else
                                    <span class="badge badge-closed">Cerrada</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('intervenciones.show', $intervencion) }}"
                                   class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="{{ route('intervenciones.edit', $intervencion) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form action="{{ route('intervenciones.destroy', $intervencion) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('¿Seguro que quieres eliminar esta intervención?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                No hay intervenciones registradas.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $intervenciones->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
