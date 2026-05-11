<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MARGARET RMS') }}</title>

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
            background-color: #f8f9fa;
            color: var(--grafito);
            font-family: Calibri, Arial, sans-serif;
        }

        .sidebar {
            min-height: 100vh;
            background-color: var(--azul-amazonico);
            color: var(--blanco);
        }

        .sidebar .brand {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.15);
            text-align: center;
        }

        .sidebar .brand img {
            max-width: 145px;
            height: auto;
            margin-bottom: 10px;
        }

        .sidebar .brand h5 {
            margin: 0;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .sidebar .brand small {
            color: rgba(255,255,255,0.8);
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,0.9);
            border-radius: 8px;
            margin-bottom: 6px;
            padding: 10px 14px;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: var(--azul-aereo);
            color: var(--grafito);
        }

        .topbar {
            background-color: var(--blanco);
            border-bottom: 1px solid #e5e5e5;
            padding: 1rem 1.5rem;
        }

        .content-area {
            padding: 1.5rem;
        }

        .page-title {
            color: var(--azul-amazonico);
            font-weight: bold;
        }

        .card-custom {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .card-stat {
            border-left: 5px solid var(--azul-aereo);
        }

        .btn-primary-custom {
            background-color: var(--azul-amazonico);
            border-color: var(--azul-amazonico);
            color: white;
        }

        .btn-primary-custom:hover {
            background-color: #003847;
            border-color: #003847;
            color: white;
        }

        .table thead {
            background-color: var(--azul-amazonico);
            color: white;
        }

        .badge-open {
            background-color: var(--amarillo-solar);
            color: var(--grafito);
        }

        .badge-closed {
            background-color: var(--azul-aereo);
            color: var(--grafito);
        }
        .dashboard-card-link {
            transition: transform 0.15s ease, box-shadow 0.15s ease;
            cursor: pointer;
        }

        .dashboard-card-link:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 18px rgba(0,0,0,0.12);
        }
        .sidebar .brand img {
            transition: transform 0.2s ease, filter 0.2s ease;
        }

        .sidebar .brand img:hover {
            transform: scale(1.04);
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.25));
        }

        .sidebar .nav-link {
            transition: background-color 0.18s ease, color 0.18s ease, transform 0.18s ease;
        }

        .sidebar .nav-link:hover {
            transform: translateX(4px);
        }

        .sidebar .nav-link:focus,
        .sidebar .nav-link:focus-visible {
            outline: 2px solid var(--amarillo-solar);
            outline-offset: 2px;
            background-color: rgba(106,194,197,0.25);
            color: var(--blanco);
        }

        .btn:focus,
        .btn:focus-visible,
        .form-control:focus,
        .form-select:focus {
            outline: none;
            box-shadow: 0 0 0 0.22rem rgba(106,194,197,0.35);
            border-color: var(--azul-aereo);
        }

        .btn-primary-custom:focus,
        .btn-primary-custom:focus-visible {
            box-shadow: 0 0 0 0.22rem rgba(251,187,33,0.40);
        }

        a:focus,
        a:focus-visible {
            outline: 2px solid var(--amarillo-solar);
            outline-offset: 3px;
            border-radius: 6px;
        }

        .table-hover tbody tr {
            transition: background-color 0.15s ease;
        }

        .card-custom {
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .card-custom:hover {
            box-shadow: 0 6px 18px rgba(0,0,0,0.08);
        }

        @media (max-width: 767.98px) {
            .sidebar {
                min-height: auto;
                padding: 0.65rem 0.75rem !important;
                display: flex;
                align-items: center;
                gap: 0.75rem;
                overflow-x: hidden;
            }

            .sidebar .brand {
                flex: 0 0 auto;
                padding: 0;
                border-bottom: none;
                text-align: left;
                display: flex;
                align-items: center;
            }

            .sidebar .brand img {
                display: block !important;
                width: 46px;
                min-width: 46px;
                max-width: 46px;
                height: auto;
                margin: 0;
            }

            .sidebar .brand h5,
            .sidebar .brand small {
                display: none;
            }

            .sidebar .nav {
                flex: 1 1 auto;
                flex-direction: row !important;
                justify-content: flex-end;
                flex-wrap: nowrap;
                gap: 0.4rem;
                margin-top: 0 !important;
                overflow-x: auto;
                padding-bottom: 0;
            }

            .sidebar .nav-link {
                width: 40px;
                height: 40px;
                min-width: 40px;
                padding: 0;
                margin-bottom: 0;
                border-radius: 11px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0;
            }

            .sidebar .nav-link i {
                font-size: 1.18rem;
                margin-right: 0 !important;
            }

            .sidebar .nav-link:hover {
                transform: translateY(-2px);
            }

            .topbar {
                flex-direction: column;
                align-items: stretch !important;
                gap: 0.75rem;
                padding: 1rem;
            }

            .topbar > div:first-child {
                width: 100%;
            }

            .topbar > div:last-child {
                width: 100%;
                display: flex;
                justify-content: space-between !important;
                align-items: center;
                gap: 0.75rem;
            }

            .topbar .text-end {
                text-align: left !important;
            }

            .topbar .page-title {
                font-size: 1.1rem;
            }

            .topbar small {
                font-size: 0.8rem;
            }

            .topbar form {
                margin-left: auto;
                flex: 0 0 auto;
            }
        }
    </style>
</head>

<body>
<div class="container-fluid">
    <div class="row">
        {{-- Menú lateral --}}
        <aside class="col-md-3 col-lg-2 sidebar p-3">
            <div class="brand">
                <img src="{{ asset('images/margaret-logo.svg') }}" alt="Logo Margaret">
                <h5>MARGARET RMS</h5>
                <small>Radar Maintenance Suite</small>
            </div>

            <nav class="nav flex-column mt-4">
                <a href="{{ route('dashboard') }}" class="nav-link">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>

                @if(auth()->user()->rol === 'admin_ansp')
                    <a href="{{ route('organizaciones.index') }}" class="nav-link">
                        <i class="bi bi-buildings me-2"></i> Organizaciones
                    </a>

                    <a href="{{ route('usuarios.index') }}" class="nav-link">
                        <i class="bi bi-people me-2"></i> Usuarios
                    </a>

                    <a href="{{ route('instalaciones.index') }}" class="nav-link">
                        <i class="bi bi-geo-alt me-2"></i> Instalaciones
                    </a>
                @endif

                <a href="{{ route('dispositivos.index') }}" class="nav-link">
                    <i class="bi bi-broadcast-pin me-2"></i> Dispositivos
                </a>

                @if(in_array(auth()->user()->rol, ['admin_ansp', 'tecnico']))
                    <a href="{{ route('intervenciones.index') }}" class="nav-link">
                        <i class="bi bi-tools me-2"></i> Intervenciones
                    </a>
                @endif
            </nav>
        </aside>

        {{-- Contenido principal --}}
        <main class="col-md-9 col-lg-10 px-0">
            <div class="topbar d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-0 page-title">
                        @isset($header)
                            {{ $header }}
                        @else
                            Panel principal
                        @endisset
                    </h4>
                    <small class="text-muted">Todos tus sensores controlados en un solo vistazo</small>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <div class="text-end">
                        <div>
                            <strong>{{ auth()->user()->name }} {{ auth()->user()->apellidos }}</strong>
                        </div>
                        <small class="text-muted">
                            {{ auth()->user()->rol }} |
                            {{ auth()->user()->organizacion?->nombre ?? 'Sin organización' }}
                        </small>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-box-arrow-right me-1"></i> Salir
                        </button>
                    </form>
                </div>
            </div>

            <div class="content-area">
                {{ $slot }}
            </div>
        </main>
    </div>
</div>
</body>
</html>
