<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoAlerta extends Model
{
    protected $table = 'tipo_alertas';

    protected $primaryKey = 'id_tipo_alerta';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'icono',
        'color',
        'estado',
        'fechacrea',
        'fechaedita',
        'fechaelimina'
    ];
}
