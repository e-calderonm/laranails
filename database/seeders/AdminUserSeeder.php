<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Administrador Principal',
            'email' => 'admin@belleza.com', // Correo para entrar
            'password' => bcrypt('password123'), // Contraseña segura (RF B2)
            'phone' => '3001234567',
            'role' => 'admin',
        ]);
    }
}
