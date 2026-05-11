<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EstadoDispositivo extends Model
{
    protected $table = 'estados_dispositivo';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function dispositivos(): HasMany
    {
        return $this->hasMany(Dispositivo::class);
    }

    public function intervencionesComoEstadoAnterior(): HasMany
    {
        return $this->hasMany(Intervencion::class, 'estado_anterior_id');
    }

    public function intervencionesComoEstadoNuevo(): HasMany
    {
        return $this->hasMany(Intervencion::class, 'estado_nuevo_id');
    }
}
