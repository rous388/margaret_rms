<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Intervencion extends Model
{
    protected $table = 'intervenciones';

    protected $fillable = [
        'dispositivo_id',
        'usuario_id',
        'tipo_intervencion_id',
        'fecha_inicio',
        'descripcion',
        'estado_anterior_id',
        'estado_nuevo_id',
        'estado_intervencion',
        'fecha_cierre',
        'fecha_prevista_cierre',
        'observaciones',
    ];

    protected function casts(): array
    {
        return [
            'fecha_inicio' => 'datetime',
            'fecha_cierre' => 'datetime',
            'fecha_prevista_cierre' => 'datetime',
        ];
    }

    public function dispositivo(): BelongsTo
    {
        return $this->belongsTo(Dispositivo::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function tipo(): BelongsTo
    {
        return $this->belongsTo(TipoIntervencion::class, 'tipo_intervencion_id');
    }

    public function estadoAnterior(): BelongsTo
    {
        return $this->belongsTo(EstadoDispositivo::class, 'estado_anterior_id');
    }

    public function estadoNuevo(): BelongsTo
    {
        return $this->belongsTo(EstadoDispositivo::class, 'estado_nuevo_id');
    }
}
