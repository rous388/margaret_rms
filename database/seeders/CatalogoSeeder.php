<?php

namespace Database\Seeders;

use App\Models\EstadoDispositivo;
use App\Models\TipoDispositivo;
use App\Models\TipoIntervencion;
use Illuminate\Database\Seeder;

class CatalogoSeeder extends Seeder
{
    public function run(): void
    {
        $tiposDispositivo = [
            ['nombre' => 'MSSR', 'descripcion' => 'Radar secundario monopulso de vigilancia.'],
            ['nombre' => 'PSR', 'descripcion' => 'Radar primario de vigilancia.'],
            ['nombre' => 'ADS-B', 'descripcion' => 'Sistema de vigilancia dependiente automática.'],
        ];

        foreach ($tiposDispositivo as $tipo) {
            TipoDispositivo::updateOrCreate(
                ['nombre' => $tipo['nombre']],
                $tipo
            );
        }

        $estadosDispositivo = [
            ['nombre' => 'Operativo', 'descripcion' => 'El dispositivo funciona correctamente.'],
            ['nombre' => 'Degradado', 'descripcion' => 'El dispositivo funciona con limitaciones.'],
            ['nombre' => 'Fuera de servicio', 'descripcion' => 'El dispositivo no se encuentra operativo.'],
            ['nombre' => 'En mantenimiento', 'descripcion' => 'El dispositivo está siendo intervenido.'],
        ];

        foreach ($estadosDispositivo as $estado) {
            EstadoDispositivo::updateOrCreate(
                ['nombre' => $estado['nombre']],
                $estado
            );
        }

        $tiposIntervencion = [
            ['nombre' => 'Preventiva', 'descripcion' => 'Actuación planificada para prevenir incidencias.'],
            ['nombre' => 'Correctiva', 'descripcion' => 'Actuación para corregir una incidencia detectada.'],
            ['nombre' => 'Modificación de configuración', 'descripcion' => 'Cambio en parámetros técnicos del sistema.'],
            ['nombre' => 'Revisión', 'descripcion' => 'Comprobación general del estado del sistema.'],
            ['nombre' => 'Incidencia', 'descripcion' => 'Registro de una anomalía o problema detectado.'],
            ['nombre' => 'Actualización de software', 'descripcion' => 'Actualización del software del sistema.'],
            ['nombre' => 'Sustitución de componente', 'descripcion' => 'Cambio físico de un componente del sistema.'],
        ];

        foreach ($tiposIntervencion as $tipo) {
            TipoIntervencion::updateOrCreate(
                ['nombre' => $tipo['nombre']],
                $tipo
            );
        }
    }
}
