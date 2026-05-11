<x-app-layout>
    <x-slot name="header">
        Nuevo dispositivo
    </x-slot>

    <div class="mb-4">
        <h5 class="mb-1">Crear dispositivo</h5>
        <p class="text-muted mb-0">
            Registra un radar MSSR, PSR o sistema ADS-B asociado a una instalación.
        </p>
    </div>

    <div class="card card-custom">
        <div class="card-body">
            <form action="{{ route('dispositivos.store') }}" method="POST">
                @include('dispositivos._form')
            </form>
        </div>
    </div>
</x-app-layout>
