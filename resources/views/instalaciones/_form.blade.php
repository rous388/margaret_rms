@csrf

<div class="row g-3">
    <div class="col-md-6">
        <label for="nombre" class="form-label">Nombre de la instalación *</label>
        <input
            type="text"
            name="nombre"
            id="nombre"
            class="form-control @error('nombre') is-invalid @enderror"
            value="{{ old('nombre', $instalacion->nombre ?? '') }}"
            required
        >
        @error('nombre')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="organizacion_id" class="form-label">Cliente final *</label>
        <select
            name="organizacion_id"
            id="organizacion_id"
            class="form-select @error('organizacion_id') is-invalid @enderror"
            required
        >
            <option value="">Selecciona un cliente</option>
            @foreach($clientes as $cliente)
                <option
                    value="{{ $cliente->id }}"
                    @selected((int) old('organizacion_id', $instalacion->organizacion_id ?? 0) === $cliente->id)
                >
                    {{ $cliente->nombre }} — {{ $cliente->pais ?? 'Sin país' }}
                </option>
            @endforeach
        </select>
        @error('organizacion_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="pais" class="form-label">País</label>
        <input
            type="text"
            name="pais"
            id="pais"
            class="form-control @error('pais') is-invalid @enderror"
            value="{{ old('pais', $instalacion->pais ?? '') }}"
        >
        @error('pais')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="ciudad_zona" class="form-label">Ciudad o zona</label>
        <input
            type="text"
            name="ciudad_zona"
            id="ciudad_zona"
            class="form-control @error('ciudad_zona') is-invalid @enderror"
            value="{{ old('ciudad_zona', $instalacion->ciudad_zona ?? '') }}"
        >
        @error('ciudad_zona')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="coordenadas" class="form-label">Coordenadas</label>
        <input
            type="text"
            name="coordenadas"
            id="coordenadas"
            class="form-control @error('coordenadas') is-invalid @enderror"
            value="{{ old('coordenadas', $instalacion->coordenadas ?? '') }}"
            placeholder="-12.0464, -77.0428"
        >
        @error('coordenadas')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="estado" class="form-label">Estado *</label>
        <select
            name="estado"
            id="estado"
            class="form-select @error('estado') is-invalid @enderror"
            required
        >
            <option value="activa" @selected(old('estado', $instalacion->estado ?? 'activa') === 'activa')>
                Activa
            </option>
            <option value="inactiva" @selected(old('estado', $instalacion->estado ?? '') === 'inactiva')>
                Inactiva
            </option>
            <option value="mantenimiento" @selected(old('estado', $instalacion->estado ?? '') === 'mantenimiento')>
                En mantenimiento
            </option>
        </select>
        @error('estado')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="observaciones" class="form-label">Observaciones</label>
        <textarea
            name="observaciones"
            id="observaciones"
            rows="4"
            class="form-control @error('observaciones') is-invalid @enderror"
        >{{ old('observaciones', $instalacion->observaciones ?? '') }}</textarea>
        @error('observaciones')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('instalaciones.index') }}" class="btn btn-outline-secondary">
        Cancelar
    </a>

    <button type="submit" class="btn btn-primary-custom">
        <i class="bi bi-save me-1"></i> Guardar instalación
    </button>
</div>
