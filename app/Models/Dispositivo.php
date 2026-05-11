<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dispositivo extends Model
{
    protected $fillable = [
        'instalacion_id',
        'tipo_dispositivo_id',
        'estado_dispositivo_id',
        'nombre',
        'codigo_sac',
        'codigo_sic',
        'coordenadas',
        'altura_antena',
        'tiempo_vuelta',
        'fecha_instalacion',
        'observaciones',
    ];

    protected function casts(): array
    {
        return [
            'fecha_instalacion' => 'date',
            'altura_antena' => 'decimal:2',
            'tiempo_vuelta' => 'decimal:2',
        ];
    }

    public function instalacion(): BelongsTo
    {
        return $this->belongsTo(Instalacion::class);
    }

    public function tipo(): BelongsTo
    {
        return $this->belongsTo(TipoDispositivo::class, 'tipo_dispositivo_id');
    }

    public function estado(): BelongsTo
    {
        return $this->belongsTo(EstadoDispositivo::class, 'estado_dispositivo_id');
    }

    public function intervenciones(): HasMany
    {
        return $this->hasMany(Intervencion::class);
    }
}
