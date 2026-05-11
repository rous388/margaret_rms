<x-app-layout>
    <x-slot name="header">
        Editar intervención
    </x-slot>

    <div class="mb-4">
        <h5 class="mb-1">Editar intervención</h5>
        <p class="text-muted mb-0">
            Modifica los datos de la intervención seleccionada.
        </p>
    </div>

    <div class="card card-custom">
        <div class="card-body">
            <form action="{{ route('intervenciones.update', $intervencion) }}" method="POST">
                @method('PUT')
                @include('intervenciones._form')
            </form>
        </div>
    </div>
</x-app-layout>
