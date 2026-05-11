<x-app-layout>
    <x-slot name="header">
        Editar instalación
    </x-slot>

    <div class="mb-4">
        <h5 class="mb-1">Editar instalación</h5>
        <p class="text-muted mb-0">
            Modifica los datos de {{ $instalacion->nombre }}.
        </p>
    </div>

    <div class="card card-custom">
        <div class="card-body">
            <form action="{{ route('instalaciones.update', $instalacion) }}" method="POST">
                @method('PUT')
                @include('instalaciones._form')
            </form>
        </div>
    </div>
</x-app-layout>
