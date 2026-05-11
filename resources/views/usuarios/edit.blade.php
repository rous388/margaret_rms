<x-app-layout>
    <x-slot name="header">
        Editar usuario
    </x-slot>

    <div class="mb-4">
        <h5 class="mb-1">Editar usuario</h5>
        <p class="text-muted mb-0">
            Modifica los datos de {{ $usuario->name }} {{ $usuario->apellidos }}.
        </p>
    </div>

    <div class="card card-custom">
        <div class="card-body">
            <form action="{{ route('usuarios.update', $usuario) }}" method="POST">
                @method('PUT')
                @include('usuarios._form')
            </form>
        </div>
    </div>
</x-app-layout>
