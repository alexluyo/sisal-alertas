<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
        'id_distrito',
        'id_anexo',
        'id_sector',
        'estado',
        'fechacrea',
        'fechaedita',
        'fechaelimina',
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

    public function anexo()
    {
        return $this->belongsTo(Anexo::class, 'id_anexo', 'id_anexo');
    }

    public function permisos()
    {
        return $this->hasMany(UsuarioPermiso::class, 'id_usuario', 'id');
    }

    public function esAdminFull(): bool
    {
        return $this->rol === 'ADMIN_FULL';
    }

    

    public function esSubAdmin(): bool
    {
        return $this->rol === 'SUBADMIN';
    }

    public function tienePermiso(string $modulo, string $accion = 'puede_ver'): bool
    {
        if ($this->esAdminFull()) {
            return true;
        }

        return $this->permisos()
            ->where('estado', 1)
            ->whereHas('modulo', function ($query) use ($modulo) {
                $query->where('clave', $modulo)
                      ->where('estado', 1);
            })
            ->where($accion, 1)
            ->exists();
    }
}
