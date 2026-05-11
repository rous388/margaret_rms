<x-app-layout>
    <x-slot name="header">
        Instalaciones
    </x-slot>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="mb-1">Gestión de instalaciones</h5>
            <p class="text-muted mb-0">
                Administra los emplazamientos donde se encuentran los radares y sensores.
            </p>
        </div>

        <a href="{{ route('instalaciones.create') }}" class="btn btn-primary-custom">
            <i class="bi bi-plus-circle me-1"></i> Nueva instalación
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card card-custom">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Cliente</th>
                        <th>País</th>
                        <th>Ciudad/Zona</th>
                        <th>Coordenadas</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($instalaciones as $instalacion)
                        <tr>
                            <td><strong>{{ $instalacion->nombre }}</strong></td>
                            <td>{{ $instalacion->organizacion?->nombre ?? '—' }}</td>
                            <td>{{ $instalacion->pais ?? '—' }}</td>
                            <td>{{ $instalacion->ciudad_zona ?? '—' }}</td>
                            <td>{{ $instalacion->coordenadas ?? '—' }}</td>
                            <td>
                                @if($instalacion->estado === 'activa')
                                    <span class="badge badge-closed">Activa</span>
                                @elseif($instalacion->estado === 'mantenimiento')
                                    <span class="badge badge-open">En mantenimiento</span>
                                @else
                                    <span class="badge text-bg-secondary">Inactiva</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('instalaciones.show', $instalacion) }}"
                                   class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="{{ route('instalaciones.edit', $instalacion) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form action="{{ route('instalaciones.destroy', $instalacion) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('¿Seguro que quieres desactivar esta instalación?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-warning">
                                        <i class="bi bi-slash-circle"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                No hay instalaciones registradas.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $instalaciones->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
