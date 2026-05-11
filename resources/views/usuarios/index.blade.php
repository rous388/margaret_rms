<x-app-layout>
    <x-slot name="header">
        Usuarios
    </x-slot>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="mb-1">Gestión de usuarios</h5>
            <p class="text-muted mb-0">
                Administra los usuarios de acceso a MARGARET RMS.
            </p>
        </div>

        <a href="{{ route('usuarios.create') }}" class="btn btn-primary-custom">
            <i class="bi bi-person-plus me-1"></i> Nuevo usuario
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle me-1"></i> {{ session('error') }}
        </div>
    @endif

    <div class="card card-custom">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Organización</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($usuarios as $usuario)
                        <tr>
                            <td>
                                <strong>{{ $usuario->name }} {{ $usuario->apellidos }}</strong>
                            </td>
                            <td>{{ $usuario->email }}</td>
                            <td>{{ $usuario->organizacion?->nombre ?? '—' }}</td>
                            <td>
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
                            </td>
                            <td>
                                @if($usuario->estado === 'activo')
                                    <span class="badge badge-closed">Activo</span>
                                @else
                                    <span class="badge badge-open">Inactivo</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('usuarios.show', $usuario) }}"
                                   class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="{{ route('usuarios.edit', $usuario) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form action="{{ route('usuarios.destroy', $usuario) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('¿Seguro que quieres desactivar este usuario?');">
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
                                No hay usuarios registrados.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $usuarios->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
