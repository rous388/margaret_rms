<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organizacion extends Model
{
    protected $table = 'organizaciones';

    protected $fillable = [
        'nombre',
        'tipo',
        'ansp_id',
        'pais',
        'email',
        'telefono',
        'estado',
        'observaciones',
    ];

    public function ansp(): BelongsTo
    {
        return $this->belongsTo(Organizacion::class, 'ansp_id');
    }

    public function clientesFinales(): HasMany
    {
        return $this->hasMany(Organizacion::class, 'ansp_id');
    }

    public function usuarios(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function instalaciones(): HasMany
    {
        return $this->hasMany(Instalacion::class);
    }
}
