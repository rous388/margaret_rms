@csrf

<div class="row g-3">
    <div class="col-md-6">
        <label for="name" class="form-label">Nombre *</label>
        <input
            type="text"
            name="name"
            id="name"
            class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $usuario->name ?? '') }}"
            required
        >
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="apellidos" class="form-label">Apellidos</label>
        <input
            type="text"
            name="apellidos"
            id="apellidos"
            class="form-control @error('apellidos') is-invalid @enderror"
            value="{{ old('apellidos', $usuario->apellidos ?? '') }}"
        >
        @error('apellidos')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="email" class="form-label">Email *</label>
        <input
            type="email"
            name="email"
            id="email"
            class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', $usuario->email ?? '') }}"
            required
        >
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="organizacion_id" class="form-label">Organización *</label>
        <select
            name="organizacion_id"
            id="organizacion_id"
            class="form-select @error('organizacion_id') is-invalid @enderror"
            required
        >
            <option value="">Selecciona una organización</option>
            @foreach($organizaciones as $organizacion)
                <option
                    value="{{ $organizacion->id }}"
                    @selected((int) old('organizacion_id', $usuario->organizacion_id ?? 0) === $organizacion->id)
                >
                    {{ $organizacion->nombre }} — {{ str_replace('_', ' ', $organizacion->tipo) }}
                </option>
            @endforeach
        </select>
        @error('organizacion_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="rol" class="form-label">Rol *</label>
        <select
            name="rol"
            id="rol"
            class="form-select @error('rol') is-invalid @enderror"
            required
        >
            <option value="">Selecciona un rol</option>
            <option value="admin_ansp" @selected(old('rol', $usuario->rol ?? '') === 'admin_ansp')>
                Administrador ANSP
            </option>
            <option value="tecnico" @selected(old('rol', $usuario->rol ?? '') === 'tecnico')>
                Técnico
            </option>
            <option value="cliente_visor" @selected(old('rol', $usuario->rol ?? '') === 'cliente_visor')>
                Cliente visor
            </option>
        </select>
        @error('rol')
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
            <option value="activo" @selected(old('estado', $usuario->estado ?? 'activo') === 'activo')>
                Activo
            </option>
            <option value="inactivo" @selected(old('estado', $usuario->estado ?? '') === 'inactivo')>
                Inactivo
            </option>
        </select>
        @error('estado')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="password" class="form-label">
            Contraseña {{ isset($usuario) ? '' : '*' }}
        </label>
        <input
            type="password"
            name="password"
            id="password"
            class="form-control @error('password') is-invalid @enderror"
            {{ isset($usuario) ? '' : 'required' }}
        >
        @if(isset($usuario))
            <small class="text-muted">Déjala vacía si no quieres cambiarla.</small>
        @endif
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="password_confirmation" class="form-label">
            Confirmar contraseña {{ isset($usuario) ? '' : '*' }}
        </label>
        <input
            type="password"
            name="password_confirmation"
            id="password_confirmation"
            class="form-control"
            {{ isset($usuario) ? '' : 'required' }}
        >
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">
        Cancelar
    </a>

    <button type="submit" class="btn btn-primary-custom">
        <i class="bi bi-save me-1"></i> Guardar usuario
    </button>
</div>
