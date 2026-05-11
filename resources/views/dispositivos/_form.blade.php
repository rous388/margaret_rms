@csrf

<div class="row g-3">
    <div class="col-md-6">
        <label for="nombre" class="form-label">Nombre del dispositivo *</label>
        <input
            type="text"
            name="nombre"
            id="nombre"
            class="form-control @error('nombre') is-invalid @enderror"
            value="{{ old('nombre', $dispositivo->nombre ?? '') }}"
            required
        >
        @error('nombre')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="instalacion_id" class="form-label">Instalación *</label>
        <select
            name="instalacion_id"
            id="instalacion_id"
            class="form-select @error('instalacion_id') is-invalid @enderror"
            required
        >
            <option value="">Selecciona una instalación</option>
            @foreach($instalaciones as $instalacion)
                <option
                    value="{{ $instalacion->id }}"
                    @selected((int) old('instalacion_id', $dispositivo->instalacion_id ?? 0) === $instalacion->id)
                >
                    {{ $instalacion->nombre }} — {{ $instalacion->organizacion?->nombre ?? 'Sin cliente' }}
                </option>
            @endforeach
        </select>
        @error('instalacion_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="tipo_dispositivo_id" class="form-label">Tipo de dispositivo *</label>
        <select
            name="tipo_dispositivo_id"
            id="tipo_dispositivo_id"
            class="form-select @error('tipo_dispositivo_id') is-invalid @enderror"
            required
        >
            <option value="">Selecciona un tipo</option>
            @foreach($tipos as $tipo)
                <option
                    value="{{ $tipo->id }}"
                    @selected((int) old('tipo_dispositivo_id', $dispositivo->tipo_dispositivo_id ?? 0) === $tipo->id)
                >
                    {{ $tipo->nombre }}
                </option>
            @endforeach
        </select>
        @error('tipo_dispositivo_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="estado_dispositivo_id" class="form-label">Estado *</label>
        <select
            name="estado_dispositivo_id"
            id="estado_dispositivo_id"
            class="form-select @error('estado_dispositivo_id') is-invalid @enderror"
            required
        >
            <option value="">Selecciona un estado</option>
            @foreach($estados as $estado)
                <option
                    value="{{ $estado->id }}"
                    @selected((int) old('estado_dispositivo_id', $dispositivo->estado_dispositivo_id ?? 0) === $estado->id)
                >
                    {{ $estado->nombre }}
                </option>
            @endforeach
        </select>
        @error('estado_dispositivo_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-3">
        <label for="codigo_sac" class="form-label">Código SAC</label>
        <input
            type="text"
            name="codigo_sac"
            id="codigo_sac"
            class="form-control @error('codigo_sac') is-invalid @enderror"
            value="{{ old('codigo_sac', $dispositivo->codigo_sac ?? '') }}"
        >
        @error('codigo_sac')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-3">
        <label for="codigo_sic" class="form-label">Código SIC</label>
        <input
            type="text"
            name="codigo_sic"
            id="codigo_sic"
            class="form-control @error('codigo_sic') is-invalid @enderror"
            value="{{ old('codigo_sic', $dispositivo->codigo_sic ?? '') }}"
        >
        @error('codigo_sic')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="coordenadas" class="form-label">Coordenadas</label>
        <input
            type="text"
            name="coordenadas"
            id="coordenadas"
            class="form-control @error('coordenadas') is-invalid @enderror"
            value="{{ old('coordenadas', $dispositivo->coordenadas ?? '') }}"
            placeholder="-12.0464, -77.0428"
        >
        @error('coordenadas')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="altura_antena" class="form-label">Altura antena AGL</label>
        <input
            type="number"
            step="0.01"
            min="0"
            name="altura_antena"
            id="altura_antena"
            class="form-control @error('altura_antena') is-invalid @enderror"
            value="{{ old('altura_antena', $dispositivo->altura_antena ?? '') }}"
        >
        @error('altura_antena')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="tiempo_vuelta" class="form-label">Tiempo por vuelta</label>
        <input
            type="number"
            step="0.01"
            min="0"
            name="tiempo_vuelta"
            id="tiempo_vuelta"
            class="form-control @error('tiempo_vuelta') is-invalid @enderror"
            value="{{ old('tiempo_vuelta', $dispositivo->tiempo_vuelta ?? '') }}"
        >
        @error('tiempo_vuelta')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="fecha_instalacion" class="form-label">Fecha de instalación</label>
        <input
            type="date"
            name="fecha_instalacion"
            id="fecha_instalacion"
            class="form-control @error('fecha_instalacion') is-invalid @enderror"
            value="{{ old('fecha_instalacion', isset($dispositivo) && $dispositivo->fecha_instalacion ? $dispositivo->fecha_instalacion->format('Y-m-d') : '') }}"
        >
        @error('fecha_instalacion')
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
        >{{ old('observaciones', $dispositivo->observaciones ?? '') }}</textarea>
        @error('observaciones')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('dispositivos.index') }}" class="btn btn-outline-secondary">
        Cancelar
    </a>

    <button type="submit" class="btn btn-primary-custom">
        <i class="bi bi-save me-1"></i> Guardar dispositivo
    </button>
</div>
