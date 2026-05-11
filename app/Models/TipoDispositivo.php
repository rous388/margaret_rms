<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoDispositivo extends Model
{
    protected $table = 'tipos_dispositivo';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function dispositivos(): HasMany
    {
        return $this->hasMany(Dispositivo::class);
    }
}
