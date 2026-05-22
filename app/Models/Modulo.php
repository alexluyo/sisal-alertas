<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    protected $table = 'modulos';

    protected $primaryKey = 'id_modulo';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'clave',
        'estado',
        'fechacrea',
        'fechaedita',
        'fechaelimina',
    ];

    public function permisos()
    {
        return $this->hasMany(UsuarioPermiso::class, 'id_modulo', 'id_modulo');
    }
}
