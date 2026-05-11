<x-app-layout>
    <x-slot name="header">
        Nueva intervención
    </x-slot>

    <div class="mb-4">
        <h5 class="mb-1">Registrar intervención</h5>
        <p class="text-muted mb-0">
            Registra una actuación técnica sobre un radar o sensor.
        </p>
    </div>

    <div class="card card-custom">
        <div class="card-body">
            <form action="{{ route('intervenciones.store') }}" method="POST">
                @include('intervenciones._form')
            </form>
        </div>
    </div>
</x-app-layout>
