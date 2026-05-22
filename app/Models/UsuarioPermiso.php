<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioPermiso extends Model
{
    protected $table = 'usuario_permisos';

    protected $primaryKey = 'id_permiso';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_modulo',
        'puede_ver',
        'puede_crear',
        'puede_editar',
        'puede_eliminar',
        'puede_enviar',
        'estado',
        'fechacrea',
        'fechaedita',
        'fechaelimina',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id');
    }

    public function modulo()
    {
        return $this->belongsTo(Modulo::class, 'id_modulo', 'id_modulo');
    }
}
