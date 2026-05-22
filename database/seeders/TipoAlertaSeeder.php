<?php

namespace Database\Seeders;

use App\Models\TipoAlerta;
use Illuminate\Database\Seeder;

class TipoAlertaSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            ['Robos', 'bi-shield-exclamation', 'danger'],
            ['Personas sospechosas', 'bi-person-exclamation', 'warning'],
            ['Pérdida de niños o adultos mayores', 'bi-search', 'primary'],
            ['Lluvias intensas', 'bi-cloud-rain-heavy', 'info'],
            ['Huaicos', 'bi-water', 'warning'],
            ['Inundaciones', 'bi-tsunami', 'primary'],
            ['Sismos', 'bi-activity', 'dark'],
            ['Incendios forestales', 'bi-fire', 'danger'],
            ['Deslizamientos', 'bi-cone-striped', 'warning'],
            ['Accidente de tránsito', 'bi-car-front-fill', 'danger'],
            ['Incendios', 'bi-fire', 'danger'],
        ];

        foreach ($tipos as [$nombre, $icono, $color]) {
            TipoAlerta::updateOrCreate(
                ['nombre' => $nombre],
                [
                    'icono' => $icono,
                    'color' => $color,
                    'estado' => 1,
                    'fechacrea' => now(),
                ]
            );
        }
    }
}