<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModulosSeeder extends Seeder
{
    public function run(): void
    {
        $modulos = [
            ['nombre' => 'Dashboard', 'clave' => 'dashboard'],
            ['nombre' => 'Anexos', 'clave' => 'anexos'],
            ['nombre' => 'Vecinos', 'clave' => 'vecinos'],
            ['nombre' => 'Alertas', 'clave' => 'alertas'],
            ['nombre' => 'Historial', 'clave' => 'historial'],
            ['nombre' => 'Usuarios', 'clave' => 'usuarios'],
            ['nombre' => 'Permisos', 'clave' => 'permisos'],
            ['nombre' => 'Reportes', 'clave' => 'reportes'],
        ];

        foreach ($modulos as $modulo) {
            DB::table('modulos')->updateOrInsert(
                ['clave' => $modulo['clave']],
                [
                    'nombre' => $modulo['nombre'],
                    'estado' => 1,
                    'fechacrea' => now(),
                ]
            );
        }
    }
}
