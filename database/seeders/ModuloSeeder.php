<?php

namespace Database\Seeders;

use App\Models\Modulo;
use Illuminate\Database\Seeder;

class ModuloSeeder extends Seeder
{
    public function run(): void
    {
        $modulos = [
            ['Dashboard', 'dashboard'],
            ['Distritos', 'distritos'],
            ['Anexos', 'anexos'],
            ['Sectores', 'sectores'],
            ['Vecinos', 'vecinos'],
            ['Alertas', 'alertas'],
            ['Historial de Alertas', 'historial_alertas'],
            ['Usuarios', 'usuarios'],
            ['Permisos', 'permisos'],
            ['Reportes', 'reportes'],
        ];

        foreach ($modulos as [$nombre, $clave]) {
            Modulo::updateOrCreate(
                ['clave' => $clave],
                [
                    'nombre' => $nombre,
                    'estado' => 1,
                    'fechacrea' => now(),
                ]
            );
        }
    }
}