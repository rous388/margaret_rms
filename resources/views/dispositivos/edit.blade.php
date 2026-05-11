<x-app-layout>
    <x-slot name="header">
        Editar dispositivo
    </x-slot>

    <div class="mb-4">
        <h5 class="mb-1">Editar dispositivo</h5>
        <p class="text-muted mb-0">
            Modifica los datos técnicos de {{ $dispositivo->nombre }}.
        </p>
    </div>

    <div class="card card-custom">
        <div class="card-body">
            <form action="{{ route('dispositivos.update', $dispositivo) }}" method="POST">
                @method('PUT')
                @include('dispositivos._form')
            </form>
        </div>
    </div>
</x-app-layout>
