<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceToken extends Model
{
    protected $table = 'device_tokens';

    protected $primaryKey = 'id_device_token';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_anexo',
        'token',
        'plataforma',
        'navegador',
        'estado',
        'fechacrea',
        'fechaedita',
        'fechaelimina',
    ];

    public function anexo()
    {
        return $this->belongsTo(Anexo::class, 'id_anexo', 'id_anexo');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id');
    }
}
