<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vecino extends Model
{
    protected $table = 'vecinos';
    protected $primaryKey = 'id_vecino';
    public $timestamps = false;

    protected $fillable = [
        'dni',
        'nombres',
        'celular',
        'direccion',
        'id_anexo',
        'token_notificacion',
        'notificaciones',
        'estado',
        'fechacrea',
        'fechaedita',
        'fechaelimina'
    ];

    public function anexo()
    {
        return $this->belongsTo(Anexo::class, 'id_anexo', 'id_anexo');
    }
}