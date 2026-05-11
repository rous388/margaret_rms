@csrf

<div class="row g-3">
    <div class="col-md-6">
        <label for="dispositivo_id" class="form-label">Dispositivo *</label>
        <select
            name="dispositivo_id"
            id="dispositivo_id"
            class="form-select @error('dispositivo_id') is-invalid @enderror"
            required
        >
            <option value="">Selecciona un dispositivo</option>
            @foreach($dispositivos as $dispositivo)
                <option
                    value="{{ $dispositivo->id }}"
                    @selected((int) old('dispositivo_id', $intervencion->dispositivo_id ?? $dispositivoSeleccionado?->id ?? 0) === $dispositivo->id)
                >
                    {{ $dispositivo->nombre }}
                    — {{ $dispositivo->instalacion?->nombre }}
                    — {{ $dispositivo->instalacion?->organizacion?->nombre }}
                </option>
            @endforeach
        </select>
        @error('dispositivo_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="tipo_intervencion_id" class="form-label">Tipo de intervención *</label>
        <select
            name="tipo_intervencion_id"
            id="tipo_intervencion_id"
            class="form-select @error('tipo_intervencion_id') is-invalid @enderror"
            required
        >
            <option value="">Selecciona un tipo</option>
            @foreach($tipos as $tipo)
                <option
                    value="{{ $tipo->id }}"
                    @selected((int) old('tipo_intervencion_id', $intervencion->tipo_intervencion_id ?? 0) === $tipo->id)
                >
                    {{ $tipo->nombre }}
                </option>
            @endforeach
        </select>
        @error('tipo_intervencion_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="fecha_inicio" class="form-label">Fecha y hora de inicio *</label>
        <input
            type="datetime-local"
            name="fecha_inicio"
            id="fecha_inicio"
            class="form-control @error('fecha_inicio') is-invalid @enderror"
            value="{{ old('fecha_inicio', isset($intervencion) && $intervencion->fecha_inicio ? $intervencion->fecha_inicio->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}"
            required
        >
        @error('fecha_inicio')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="estado_intervencion" class="form-label">Estado de la intervención *</label>
        <select
            name="estado_intervencion"
            id="estado_intervencion"
            class="form-select @error('estado_intervencion') is-invalid @enderror"
            required
        >
            <option value="abierta" @selected(old('estado_intervencion', $intervencion->estado_intervencion ?? 'abierta') === 'abierta')>
                Abierta
            </option>
            <option value="cerrada" @selected(old('estado_intervencion', $intervencion->estado_intervencion ?? '') === 'cerrada')>
                Cerrada
            </option>
        </select>
        @error('estado_intervencion')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="estado_anterior_id" class="form-label">Estado anterior</label>
        <select
            name="estado_anterior_id"
            id="estado_anterior_id"
            class="form-select @error('estado_anterior_id') is-invalid @enderror"
        >
            <option value="">Sin estado anterior</option>
            @foreach($estados as $estado)
                <option
                    value="{{ $estado->id }}"
                    @selected((int) old('estado_anterior_id', $intervencion->estado_anterior_id ?? $dispositivoSeleccionado?->estado_dispositivo_id ?? 0) === $estado->id)
                >
                    {{ $estado->nombre }}
                </option>
            @endforeach
        </select>
        @error('estado_anterior_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="estado_nuevo_id" class="form-label">Estado nuevo</label>
        <select
            name="estado_nuevo_id"
            id="estado_nuevo_id"
            class="form-select @error('estado_nuevo_id') is-invalid @enderror"
        >
            <option value="">Sin cambio de estado</option>
            @foreach($estados as $estado)
                <option
                    value="{{ $estado->id }}"
                    @selected((int) old('estado_nuevo_id', $intervencion->estado_nuevo_id ?? 0) === $estado->id)
                >
                    {{ $estado->nombre }}
                </option>
            @endforeach
        </select>
        @error('estado_nuevo_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="fecha_cierre" class="form-label">Fecha de cierre</label>
        <input
            type="datetime-local"
            name="fecha_cierre"
            id="fecha_cierre"
            class="form-control @error('fecha_cierre') is-invalid @enderror"
            value="{{ old('fecha_cierre', isset($intervencion) && $intervencion->fecha_cierre ? $intervencion->fecha_cierre->format('Y-m-d\TH:i') : '') }}"
        >
        <small class="text-muted">Obligatoria si la intervención está cerrada.</small>
        @error('fecha_cierre')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="fecha_prevista_cierre" class="form-label">Fecha prevista de cierre</label>
        <input
            type="datetime-local"
            name="fecha_prevista_cierre"
            id="fecha_prevista_cierre"
            class="form-control @error('fecha_prevista_cierre') is-invalid @enderror"
            value="{{ old('fecha_prevista_cierre', isset($intervencion) && $intervencion->fecha_prevista_cierre ? $intervencion->fecha_prevista_cierre->format('Y-m-d\TH:i') : '') }}"
        >
        <small class="text-muted">Obligatoria si la intervención queda abierta.</small>
        @error('fecha_prevista_cierre')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="descripcion" class="form-label">Descripción del trabajo realizado *</label>
        <textarea
            name="descripcion"
            id="descripcion"
            rows="4"
            class="form-control @error('descripcion') is-invalid @enderror"
            required
        >{{ old('descripcion', $intervencion->descripcion ?? '') }}</textarea>
        @error('descripcion')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="observaciones" class="form-label">Observaciones</label>
        <textarea
            name="observaciones"
            id="observaciones"
            rows="3"
            class="form-control @error('observaciones') is-invalid @enderror"
        >{{ old('observaciones', $intervencion->observaciones ?? '') }}</textarea>
        @error('observaciones')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('intervenciones.index') }}" class="btn btn-outline-secondary">
        Cancelar
    </a>

    <button type="submit" class="btn btn-primary-custom">
        <i class="bi bi-save me-1"></i> Guardar intervención
    </button>
</div>
