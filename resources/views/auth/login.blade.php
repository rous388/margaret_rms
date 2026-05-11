<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Acceso | MARGARET RMS</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --azul-amazonico: #00495D;
            --amarillo-solar: #FBBB21;
            --azul-aereo: #6AC2C5;
            --gris-niebla: #DFE0E1;
            --grafito: #2C2C2D;
            --blanco: #FFFFFF;
        }

        body {
            min-height: 100vh;
            background:
                linear-gradient(135deg, rgba(0,73,93,0.94), rgba(0,73,93,0.80)),
                radial-gradient(circle at top right, rgba(106,194,197,0.35), transparent 35%),
                #00495D;
            font-family: Calibri, Arial, sans-serif;
            color: var(--grafito);
        }

        .login-wrapper {
            min-height: 100vh;
        }

        .login-card {
            width: 100%;
            max-width: 430px;
            border: none;
            border-radius: 18px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.25);
            overflow: hidden;
        }

        .login-header {
            background-color: var(--azul-amazonico);
            color: white;
            text-align: center;
            padding: 2rem 2rem 1.5rem;
            border-bottom: 5px solid var(--amarillo-solar);
        }

        .logo-wrapper {
            max-width: 155px;
            margin: 0 auto 1rem;
            opacity: 0;
            transform: scale(0.6) rotate(-10deg);
            animation: logoMainReveal 1s ease-out forwards;
        }

        .margaret-logo-svg {
            width: 100%;
            height: auto;
            display: block;
            overflow: visible;
        }

        .margaret-logo-svg path,
        .margaret-logo-svg ellipse {
            opacity: 0;
            transform-box: fill-box;
            transform-origin: center;
            animation: logoPieceReveal 1.1s ease-out forwards;
        }

        .margaret-logo-svg path:nth-of-type(odd) {
            transform: translateY(-18px) scale(0.55) rotate(-14deg);
            animation-delay: 0.35s;
        }

        .margaret-logo-svg path:nth-of-type(even) {
            transform: translateY(18px) scale(0.55) rotate(14deg);
            animation-delay: 0.55s;
        }

        .margaret-logo-svg ellipse {
            transform: scale(0.35);
            animation-delay: 1s;
        }

        @keyframes logoMainReveal {
            from {
                opacity: 0;
                transform: scale(0.6) rotate(-10deg);
                filter: blur(5px);
            }
            to {
                opacity: 1;
                transform: scale(1) rotate(0deg);
                filter: blur(0);
            }
        }

        @keyframes logoPieceReveal {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
                    transform: translateY(0) scale(1) rotate(0deg);

            }
        }

        .login-header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.2rem;
            letter-spacing: 0.5px;
        }

        .login-header p {
            margin: 0;
            color: rgba(255,255,255,0.82);
            font-size: 0.95rem;
        }

        .login-body {
            background-color: white;
            padding: 2rem;
            opacity: 0;
            transform: translateY(12px);
            animation: bodyReveal 0.8s ease-out forwards;
            animation-delay: 1.55s;
        }

        @keyframes bodyReveal {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-label {
            font-weight: 600;
            color: var(--grafito);
        }

        .form-control {
            border-radius: 10px;
            padding: 0.7rem 0.85rem;
        }

        .form-control:focus {
            border-color: var(--azul-aereo);
            box-shadow: 0 0 0 0.2rem rgba(106,194,197,0.25);
        }

        .btn-login {
            background-color: var(--azul-amazonico);
            border-color: var(--azul-amazonico);
            color: white;
            border-radius: 10px;
            padding: 0.75rem;
            font-weight: 600;
        }

        .btn-login:hover {
            background-color: #003847;
            border-color: #003847;
            color: white;
        }

        .login-footer {
            font-size: 0.85rem;
            color: #6c757d;
            text-align: center;
            margin-top: 1.2rem;
        }

        .accent-line {
            width: 70px;
            height: 4px;
            background-color: var(--amarillo-solar);
            border-radius: 999px;
            margin: 0.75rem auto 0;
            transform: scaleX(0);
            transform-origin: left;
            animation: lineReveal 0.8s ease forwards;
            animation-delay: 1.35s;
        }

        @keyframes lineReveal {
            from {
                transform: scaleX(0);
            }
            to {
                transform: scaleX(1);
            }
        }
    </style>
</head>

<body>
<div class="container login-wrapper d-flex align-items-center justify-content-center px-3">
    <div class="card login-card">
        <div class="login-header">
            <div class="logo-wrapper">
            @include('components.margaret-logo-animated')
            </div>
            <h1>MARGARET RMS</h1>
            <p>Radar Maintenance Suite</p>
            <div class="accent-line"></div>
        </div>

        <div class="login-body">
            <h5 class="mb-1 text-center fw-bold" style="color:#00495D;">
                Acceso a la plataforma
            </h5>
            <p class="text-muted text-center mb-4">
                Introduce tus credenciales para continuar.
            </p>

            {{-- Estado de sesión --}}
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Errores --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    Revisa las credenciales introducidas.
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="usuario@margaret.test"
                    >

                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        required
                        autocomplete="current-password"
                        placeholder="Introduce tu contraseña"
                    >

                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input
                            id="remember_me"
                            type="checkbox"
                            class="form-check-input"
                            name="remember"
                        >
                        <label class="form-check-label" for="remember_me">
                            Recordarme
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                        <a class="small text-decoration-none" style="color:#00495D;" href="{{ route('password.request') }}">
                            ¿Olvidaste la contraseña?
                        </a>
                    @endif
                </div>

                <button type="submit" class="btn btn-login w-100">
                    <i class="bi bi-box-arrow-in-right me-1"></i>
                    Iniciar sesión
                </button>
            </form>

            <div class="login-footer">
                Acceso restringido a usuarios autorizados.
            </div>
        </div>
    </div>
</div>
</body>
</html>
