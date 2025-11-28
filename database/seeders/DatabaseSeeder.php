<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Llamamos a TU seeder del administrador
        $this->call(AdminUserSeeder::class);
        $this->call(ServiceSeeder::class); // <-- Agrega esta línea
    }
}