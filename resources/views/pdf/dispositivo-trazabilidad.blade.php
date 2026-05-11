<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informe de trazabilidad</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #2C2C2D;
            margin: 30px;
        }

        .header {
            border-bottom: 3px solid #00495D;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        .title {
            color: #00495D;
            font-size: 22px;
            font-weight: bold;
            margin: 0;
        }

        .subtitle {
            margin: 4px 0 0 0;
            color: #555;
            font-size: 12px;
        }

        .section-title {
            background: #00495D;
            color: white;
            padding: 7px 9px;
            font-weight: bold;
            margin-top: 18px;
            margin-bottom: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        th {
            background: #DFE0E1;
            color: #2C2C2D;
            text-align: left;
            padding: 7px;
            border: 1px solid #c8c9ca;
        }

        td {
            padding: 7px;
            border: 1px solid #d8d8d8;
            vertical-align: top;
        }

        .badge {
            display: inline-block;
            padding: 3px 7px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
        }

        .badge-ok {
            background: #6AC2C5;
            color: #2C2C2D;
        }

        .badge-warning {
            background: #FBBB21;
            color: #2C2C2D;
        }

        .footer {
            margin-top: 30px;
            font-size: 9px;
            color: #666;
            border-top: 1px solid #DFE0E1;
            padding-top: 8px;
        }
    </style>
</head>
<body>

<div class="header">
    <h1 class="title">MARGARET RMS</h1>
    <p class="subtitle">Informe de trazabilidad de dispositivo</p>
    <p class="subtitle">Generado el {{ $fechaGeneracion->format('d/m/Y H:i') }}</p>
</div>

<div class="section-title">1. Datos generales del dispositivo</div>
<table>
    <tr>
        <th>Nombre</th>
        <td>{{ $dispositivo->nombre }}</td>
        <th>Tipo</th>
        <td>{{ $dispositivo->tipo?->nombre ?? '—' }}</td>
    </tr>
    <tr>
        <th>Estado actual</th>
        <td>{{ $dispositivo->estado?->nombre ?? '—' }}</td>
        <th>Fecha instalación</th>
        <td>{{ $dispositivo->fecha_instalacion?->format('d/m/Y') ?? '—' }}</td>
    </tr>
    <tr>
        <th>Cliente</th>
        <td>{{ $dispositivo->instalacion?->organizacion?->nombre ?? '—' }}</td>
        <th>Instalación</th>
        <td>{{ $dispositivo->instalacion?->nombre ?? '—' }}</td>
    </tr>
</table>

<div class="section-title">2. Datos técnicos</div>
<table>
    <tr>
        <th>Código SAC</th>
        <td>{{ $dispositivo->codigo_sac ?? '—' }}</td>
        <th>Código SIC</th>
        <td>{{ $dispositivo->codigo_sic ?? '—' }}</td>
    </tr>
    <tr>
        <th>Coordenadas</th>
        <td>{{ $dispositivo->coordenadas ?? '—' }}</td>
        <th>Altura antena</th>
        <td>{{ $dispositivo->altura_antena !== null ? $dispositivo->altura_antena . ' m' : '—' }}</td>
    </tr>
    <tr>
        <th>Tiempo por vuelta</th>
        <td>{{ $dispositivo->tiempo_vuelta !== null ? $dispositivo->tiempo_vuelta . ' s' : '—' }}</td>
        <th>Observaciones</th>
        <td>{{ $dispositivo->observaciones ?? '—' }}</td>
    </tr>
</table>

<div class="section-title">3. Historial de intervenciones</div>

@if($dispositivo->intervenciones->count() > 0)
    <table>
        <thead>
        <tr>
            <th>Fecha</th>
            <th>Tipo</th>
            <th>Técnico</th>
            <th>Estado intervención</th>
            <th>Cambio de estado</th>
        </tr>
        </thead>
        <tbody>
        @foreach($dispositivo->intervenciones->sortByDesc('fecha_inicio') as $intervencion)
            <tr>
                <td>{{ $intervencion->fecha_inicio?->format('d/m/Y H:i') }}</td>
                <td>{{ $intervencion->tipo?->nombre ?? '—' }}</td>
                <td>
                    {{ $intervencion->usuario?->name }}
                    {{ $intervencion->usuario?->apellidos }}
                </td>
                <td>
                    @if($intervencion->estado_intervencion === 'abierta')
                        <span class="badge badge-warning">Abierta</span>
                    @else
                        <span class="badge badge-ok">Cerrada</span>
                    @endif
                </td>
                <td>
                    {{ $intervencion->estadoAnterior?->nombre ?? '—' }}
                    →
                    {{ $intervencion->estadoNuevo?->nombre ?? '—' }}
                </td>
            </tr>
            <tr>
                <td colspan="5">
                    <strong>Descripción:</strong> {{ $intervencion->descripcion }}
                    @if($intervencion->observaciones)
                        <br>
                        <strong>Observaciones:</strong> {{ $intervencion->observaciones }}
                    @endif

                    @if($intervencion->fecha_cierre)
                        <br>
                        <strong>Fecha cierre:</strong> {{ $intervencion->fecha_cierre->format('d/m/Y H:i') }}
                    @endif

                    @if($intervencion->fecha_prevista_cierre)
                        <br>
                        <strong>Fecha prevista de cierre:</strong> {{ $intervencion->fecha_prevista_cierre->format('d/m/Y H:i') }}
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <p>No existen intervenciones registradas para este dispositivo.</p>
@endif

<div class="footer">
    Informe generado automáticamente por MARGARET RMS. Documento orientado a consulta de trazabilidad técnica.
</div>

</body>
</html>
