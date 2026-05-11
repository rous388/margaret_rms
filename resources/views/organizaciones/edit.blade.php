<x-app-layout>
    <x-slot name="header">
        Editar organización
    </x-slot>

    <div class="mb-4">
        <h5 class="mb-1">Editar organización</h5>
        <p class="text-muted mb-0">
            Modifica los datos de {{ $organizacion->nombre }}.
        </p>
    </div>

    <div class="card card-custom">
        <div class="card-body">
            <form action="{{ route('organizaciones.update', $organizacion) }}" method="POST">
                @method('PUT')
                @include('organizaciones._form')
            </form>
        </div>
    </div>
</x-app-layout>
