<x-app-layout>
    <x-slot name="header">
        Nueva instalación
    </x-slot>

    <div class="mb-4">
        <h5 class="mb-1">Crear instalación</h5>
        <p class="text-muted mb-0">
            Registra un emplazamiento asociado a un cliente final.
        </p>
    </div>

    <div class="card card-custom">
        <div class="card-body">
            <form action="{{ route('instalaciones.store') }}" method="POST">
                @include('instalaciones._form')
            </form>
        </div>
    </div>
</x-app-layout>
