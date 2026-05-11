<x-app-layout>
    <x-slot name="header">
        Organizaciones
    </x-slot>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="mb-1">Gestión de organizaciones</h5>
            <p class="text-muted mb-0">
                Administra ANSPs, clientes finales, fabricantes u otras organizaciones.
            </p>
        </div>

        <a href="{{ route('organizaciones.create') }}" class="btn btn-primary-custom">
            <i class="bi bi-plus-circle me-1"></i> Nueva organización
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
                        <th>Tipo</th>
                        <th>ANSP asociado</th>
                        <th>País</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($organizaciones as $organizacion)
                        <tr>
                            <td>
                                <strong>{{ $organizacion->nombre }}</strong>
                                @if($organizacion->email)
                                    <br>
                                    <small class="text-muted">{{ $organizacion->email }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge text-bg-light border">
                                    {{ str_replace('_', ' ', ucfirst($organizacion->tipo)) }}
                                </span>
                            </td>
                            <td>
                                {{ $organizacion->ansp?->nombre ?? '—' }}
                            </td>
                            <td>{{ $organizacion->pais ?? '—' }}</td>
                            <td>
                                @if($organizacion->estado === 'activa')
                                    <span class="badge badge-closed">Activa</span>
                                @else
                                    <span class="badge badge-open">Inactiva</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('organizaciones.show', $organizacion) }}"
                                   class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="{{ route('organizaciones.edit', $organizacion) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form action="{{ route('organizaciones.destroy', $organizacion) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('¿Seguro que quieres desactivar esta organización?');">
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
                            <td colspan="6" class="text-center text-muted py-4">
                                No hay organizaciones registradas.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $organizaciones->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
