<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Instalacion extends Model
{
    protected $table = 'instalaciones';

    protected $fillable = [
        'organizacion_id',
        'nombre',
        'pais',
        'ciudad_zona',
        'coordenadas',
        'estado',
        'observaciones',
    ];

    public function organizacion(): BelongsTo
    {
        return $this->belongsTo(Organizacion::class);
    }

    public function dispositivos(): HasMany
    {
        return $this->hasMany(Dispositivo::class);
    }
}
