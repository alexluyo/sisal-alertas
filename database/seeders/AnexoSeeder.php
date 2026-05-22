<?php

namespace Database\Seeders;

use App\Models\Anexo;
use Illuminate\Database\Seeder;

class AnexoSeeder extends Seeder
{
    public function run(): void
    {
        $anexos = [
            'Anexo de Jita',
            'Anexo de Ramadilla',
            'Anexo de Con-Con',
            'Anexo de Lúcumo',
            'Anexo de Socsi',
            'Anexo de Paullo',
            'Anexo de San Jerónimo',
            'Anexo de Langla',
            'Anexo de Condoray',
            'Anexo de Uchupampa',
            'Anexo de Catapalla',
            'Cercado de Lunahuaná',
        ];

        foreach ($anexos as $nombre) {
            Anexo::updateOrCreate(
                ['nombre' => $nombre],
                [
                    'descripcion' => $nombre,
                    'estado' => 1,
                    'fechacrea' => now(),
                    'fechaedita' => now(),
                ]
            );
        }
    }
}