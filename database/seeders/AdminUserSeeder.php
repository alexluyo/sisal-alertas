<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'alexluyo@msn.com'],
            [
                'name' => 'Alexander Luyo Sánchezperu',
                'password' => Hash::make('gzg673@Peru'),
                'rol' => 'ADMIN_FULL',
                'estado' => 1,
            ]
        );
    }
}