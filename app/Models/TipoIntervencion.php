<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoIntervencion extends Model
{
    protected $table = 'tipos_intervencion';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function intervenciones(): HasMany
    {
        return $this->hasMany(Intervencion::class);
    }
}
