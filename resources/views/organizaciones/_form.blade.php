@csrf

<div class="row g-3">
    <div class="col-md-6">
        <label for="nombre" class="form-label">Nombre *</label>
        <input
            type="text"
            name="nombre"
            id="nombre"
            class="form-control @error('nombre') is-invalid @enderror"
            value="{{ old('nombre', $organizacion->nombre ?? '') }}"
            required
        >
        @error('nombre')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="tipo" class="form-label">Tipo de organización *</label>
        <select
            name="tipo"
            id="tipo"
            class="form-select @error('tipo') is-invalid @enderror"
            required
        >
            <option value="">Selecciona un tipo</option>
            <option value="ansp" @selected(old('tipo', $organizacion->tipo ?? '') === 'ansp')>ANSP</option>
            <option value="cliente_final" @selected(old('tipo', $organizacion->tipo ?? '') === 'cliente_final')>Cliente final</option>
            <option value="fabricante" @selected(old('tipo', $organizacion->tipo ?? '') === 'fabricante')>Fabricante</option>
            <option value="otro" @selected(old('tipo', $organizacion->tipo ?? '') === 'otro')>Otro</option>
        </select>
        @error('tipo')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="ansp_id" class="form-label">ANSP asociado</label>
        <select
            name="ansp_id"
            id="ansp_id"
            class="form-select @error('ansp_id') is-invalid @enderror"
        >
            <option value="">Sin ANSP asociado</option>
            @foreach($ansps as $ansp)
                <option
                    value="{{ $ansp->id }}"
                    @selected((int) old('ansp_id', $organizacion->ansp_id ?? 0) === $ansp->id)
                >
                    {{ $ansp->nombre }}
                </option>
            @endforeach
        </select>
        <small class="text-muted">
            Solo se usa para clientes finales asociados a un ANSP.
        </small>
        @error('ansp_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="pais" class="form-label">País</label>
        <input
            type="text"
            name="pais"
            id="pais"
            class="form-control @error('pais') is-invalid @enderror"
            value="{{ old('pais', $organizacion->pais ?? '') }}"
        >
        @error('pais')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="email" class="form-label">Email corporativo</label>
        <input
            type="email"
            name="email"
            id="email"
            class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', $organizacion->email ?? '') }}"
        >
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="telefono" class="form-label">Teléfono</label>
        <input
            type="text"
            name="telefono"
            id="telefono"
            class="form-control @error('telefono') is-invalid @enderror"
            value="{{ old('telefono', $organizacion->telefono ?? '') }}"
        >
        @error('telefono')
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
            <option value="activa" @selected(old('estado', $organizacion->estado ?? 'activa') === 'activa')>Activa</option>
            <option value="inactiva" @selected(old('estado', $organizacion->estado ?? '') === 'inactiva')>Inactiva</option>
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
        >{{ old('observaciones', $organizacion->observaciones ?? '') }}</textarea>
        @error('observaciones')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('organizaciones.index') }}" class="btn btn-outline-secondary">
        Cancelar
    </a>

    <button type="submit" class="btn btn-primary-custom">
        <i class="bi bi-save me-1"></i> Guardar organización
    </button>
</div>
