<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'apellidos',
        'email',
        'password',
        'organizacion_id',
        'rol',
        'estado',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function organizacion(): BelongsTo
    {
        return $this->belongsTo(Organizacion::class);
    }

    public function intervenciones(): HasMany
    {
        return $this->hasMany(Intervencion::class, 'usuario_id');
    }

    public function esAdminAnsp(): bool
    {
        return $this->rol === 'admin_ansp';
    }

    public function esTecnico(): bool
    {
        return $this->rol === 'tecnico';
    }

    public function esClienteVisor(): bool
    {
        return $this->rol === 'cliente_visor';
    }

    public function estaActivo(): bool
    {
        return $this->estado === 'activo';
    }
}
