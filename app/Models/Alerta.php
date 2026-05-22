<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alerta extends Model
{
    protected $table = 'alertas';

    protected $primaryKey = 'id_alerta';

    public $timestamps = false;

    protected $fillable = [
        'id_tipo_alerta',
        'titulo',
        'mensaje',
        'evidencia',
        'id_anexo',
        'id_usuario',
        'estado',
        'fecha_envio',
        'fechacrea',
        'fechaedita',
        'fechaelimina'
    ];

    public function anexo()
    {
        return $this->belongsTo(Anexo::class, 'id_anexo', 'id_anexo');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id');
    }

    public function tipo()
    {
        return $this->belongsTo(TipoAlerta::class, 'id_tipo_alerta', 'id_tipo_alerta');
    }
}
