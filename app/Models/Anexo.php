<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anexo extends Model
{
    protected $table = 'anexos';
    protected $primaryKey = 'id_anexo';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'estado',
        'fechacrea',
        'fechaedita',
        'fechaelimina'
    ];
}
