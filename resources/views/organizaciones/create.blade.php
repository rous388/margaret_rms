<x-app-layout>
    <x-slot name="header">
        Nueva organización
    </x-slot>

    <div class="mb-4">
        <h5 class="mb-1">Crear organización</h5>
        <p class="text-muted mb-0">
            Registra un ANSP, cliente final, fabricante u otra organización.
        </p>
    </div>

    <div class="card card-custom">
        <div class="card-body">
            <form action="{{ route('organizaciones.store') }}" method="POST">
                @include('organizaciones._form')
            </form>
        </div>
    </div>
</x-app-layout>
