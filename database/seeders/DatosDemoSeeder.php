<?php

namespace Database\Seeders;

use App\Models\Dispositivo;
use App\Models\EstadoDispositivo;
use App\Models\Instalacion;
use App\Models\Intervencion;
use App\Models\Organizacion;
use App\Models\TipoDispositivo;
use App\Models\TipoIntervencion;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatosDemoSeeder extends Seeder
{
    public function run(): void
    {
        $indra = Organizacion::updateOrCreate(
            ['nombre' => 'INDRA'],
            [
                'tipo' => 'ansp',
                'pais' => 'España',
                'email' => 'admin@indra-demo.com',
                'telefono' => '+34 000 000 000',
                'estado' => 'activa',
                'observaciones' => 'ANSP / cliente principal de demostración.',
            ]
        );

        $corpac = Organizacion::updateOrCreate(
            ['nombre' => 'CORPAC'],
            [
                'tipo' => 'cliente_final',
                'ansp_id' => $indra->id,
                'pais' => 'Perú',
                'estado' => 'activa',
                'observaciones' => 'Cliente final asociado a INDRA.',
            ]
        );

        $dinacia = Organizacion::updateOrCreate(
            ['nombre' => 'DINACIA'],
            [
                'tipo' => 'cliente_final',
                'ansp_id' => $indra->id,
                'pais' => 'Uruguay',
                'estado' => 'activa',
                'observaciones' => 'Cliente final asociado a INDRA.',
            ]
        );

        $cocesna = Organizacion::updateOrCreate(
            ['nombre' => 'COCESNA'],
            [
                'tipo' => 'cliente_final',
                'ansp_id' => $indra->id,
                'pais' => 'Honduras',
                'estado' => 'activa',
                'observaciones' => 'Cliente final asociado a INDRA.',
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@margaret.test'],
            [
                'name' => 'Administrador',
                'apellidos' => 'ANSP',
                'password' => Hash::make('password'),
                'organizacion_id' => $indra->id,
                'rol' => 'admin_ansp',
                'estado' => 'activo',
            ]
        );

        $tecnico = User::updateOrCreate(
            ['email' => 'tecnico@margaret.test'],
            [
                'name' => 'Técnico',
                'apellidos' => 'Mantenimiento',
                'password' => Hash::make('password'),
                'organizacion_id' => $indra->id,
                'rol' => 'tecnico',
                'estado' => 'activo',
            ]
        );

        User::updateOrCreate(
            ['email' => 'cliente@margaret.test'],
            [
                'name' => 'Cliente',
                'apellidos' => 'Visor CORPAC',
                'password' => Hash::make('password'),
                'organizacion_id' => $corpac->id,
                'rol' => 'cliente_visor',
                'estado' => 'activo',
            ]
        );

        $instalacionLima = Instalacion::updateOrCreate(
            ['nombre' => 'Centro Radar Lima'],
            [
                'organizacion_id' => $corpac->id,
                'pais' => 'Perú',
                'ciudad_zona' => 'Lima',
                'coordenadas' => '-12.0464, -77.0428',
                'estado' => 'activa',
                'observaciones' => 'Instalación principal de demostración.',
            ]
        );

        $instalacionMontevideo = Instalacion::updateOrCreate(
            ['nombre' => 'Centro Radar Montevideo'],
            [
                'organizacion_id' => $dinacia->id,
                'pais' => 'Uruguay',
                'ciudad_zona' => 'Montevideo',
                'coordenadas' => '-34.9011, -56.1645',
                'estado' => 'activa',
                'observaciones' => 'Instalación de demostración para Uruguay.',
            ]
        );

        $mssr = TipoDispositivo::where('nombre', 'MSSR')->first();
        $psr = TipoDispositivo::where('nombre', 'PSR')->first();
        $adsb = TipoDispositivo::where('nombre', 'ADS-B')->first();

        $operativo = EstadoDispositivo::where('nombre', 'Operativo')->first();
        $degradado = EstadoDispositivo::where('nombre', 'Degradado')->first();
        $mantenimiento = EstadoDispositivo::where('nombre', 'En mantenimiento')->first();

        $radarLima = Dispositivo::updateOrCreate(
            ['nombre' => 'MSSR Lima Norte'],
            [
                'instalacion_id' => $instalacionLima->id,
                'tipo_dispositivo_id' => $mssr->id,
                'estado_dispositivo_id' => $operativo->id,
                'codigo_sac' => '123',
                'codigo_sic' => '45',
                'coordenadas' => '-12.0464, -77.0428',
                'altura_antena' => 38.50,
                'tiempo_vuelta' => 4.00,
                'fecha_instalacion' => '2023-06-15',
                'observaciones' => 'Radar MSSR operativo.',
            ]
        );

        Dispositivo::updateOrCreate(
            ['nombre' => 'PSR Lima Sur'],
            [
                'instalacion_id' => $instalacionLima->id,
                'tipo_dispositivo_id' => $psr->id,
                'estado_dispositivo_id' => $degradado->id,
                'codigo_sac' => '124',
                'codigo_sic' => '46',
                'coordenadas' => '-12.0800, -77.0300',
                'altura_antena' => 42.00,
                'tiempo_vuelta' => 5.00,
                'fecha_instalacion' => '2022-11-10',
                'observaciones' => 'Radar con degradación pendiente de revisión.',
            ]
        );

        Dispositivo::updateOrCreate(
            ['nombre' => 'ADS-B Montevideo'],
            [
                'instalacion_id' => $instalacionMontevideo->id,
                'tipo_dispositivo_id' => $adsb->id,
                'estado_dispositivo_id' => $mantenimiento->id,
                'codigo_sac' => '210',
                'codigo_sic' => '15',
                'coordenadas' => '-34.9011, -56.1645',
                'altura_antena' => 20.00,
                'tiempo_vuelta' => null,
                'fecha_instalacion' => '2024-01-20',
                'observaciones' => 'Sistema ADS-B en mantenimiento.',
            ]
        );

        $preventiva = TipoIntervencion::where('nombre', 'Preventiva')->first();
        $revision = TipoIntervencion::where('nombre', 'Revisión')->first();

        Intervencion::updateOrCreate(
            [
                'dispositivo_id' => $radarLima->id,
                'fecha_inicio' => '2026-05-01 08:30:00',
            ],
            [
                'usuario_id' => $tecnico->id,
                'tipo_intervencion_id' => $preventiva->id,
                'descripcion' => 'Revisión preventiva del sistema y comprobación de parámetros básicos.',
                'estado_anterior_id' => $operativo->id,
                'estado_nuevo_id' => $operativo->id,
                'estado_intervencion' => 'cerrada',
                'fecha_cierre' => '2026-05-01 10:00:00',
                'fecha_prevista_cierre' => null,
                'observaciones' => 'Sistema verificado sin incidencias.',
            ]
        );

        Intervencion::updateOrCreate(
            [
                'dispositivo_id' => $radarLima->id,
                'fecha_inicio' => '2026-05-04 09:00:00',
            ],
            [
                'usuario_id' => $tecnico->id,
                'tipo_intervencion_id' => $revision->id,
                'descripcion' => 'Revisión de trazabilidad y comprobación de configuración SAC/SIC.',
                'estado_anterior_id' => $operativo->id,
                'estado_nuevo_id' => $operativo->id,
                'estado_intervencion' => 'abierta',
                'fecha_cierre' => null,
                'fecha_prevista_cierre' => '2026-05-10 12:00:00',
                'observaciones' => 'Pendiente de validación final.',
            ]
        );
    }
}
