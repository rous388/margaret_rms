<x-app-layout>
    <x-slot name="header">
        Nuevo usuario
    </x-slot>

    <div class="mb-4">
        <h5 class="mb-1">Crear usuario</h5>
        <p class="text-muted mb-0">
            Crea una nueva cuenta de acceso para administrador, técnico o cliente visor.
        </p>
    </div>

    <div class="card card-custom">
        <div class="card-body">
            <form action="{{ route('usuarios.store') }}" method="POST">
                @include('usuarios._form')
            </form>
        </div>
    </div>
</x-app-layout>
