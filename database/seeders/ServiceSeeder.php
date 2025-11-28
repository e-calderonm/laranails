<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Categoría: UÑAS
        $unas = [
            ['name' => 'Manicura tradicional', 'price' => 20000],
            ['name' => 'Pedicura tradicional', 'price' => 20000],
            ['name' => 'Pedi Spa', 'price' => 60000],
            ['name' => 'Pedicura clínico', 'price' => 50000], // Asumo precio similar o el de la foto
            ['name' => 'Semipermanente', 'price' => 50000],
            ['name' => 'Base Rubber', 'price' => 60000],
            ['name' => 'Recubrimiento', 'price' => 75000],
            ['name' => 'Press on', 'price' => 85000],
        ];

        foreach ($unas as $s) {
            Service::create([
                'name' => $s['name'],
                'category' => 'UÑAS',
                'price' => $s['price'],
                'duration_minutes' => 60, // Tiempo estimado por defecto
                'description' => 'Servicio especializado de uñas.'
            ]);
        }

        // 2. Categoría: CEJAS, PESTAÑAS Y OTROS
        $cejas = [
            ['name' => 'Laminado de cejas', 'price' => 55000],
            ['name' => 'Lifting de pestañas', 'price' => 55000],
            ['name' => 'Pestañas punto a punto', 'price' => 25000],
            ['name' => 'Maquillaje', 'price' => 70000],
            ['name' => 'Hidralips', 'price' => 50000],
            ['name' => 'Cepillado', 'price' => 15000],
            ['name' => 'Planchado', 'price' => 15000],
            ['name' => 'Ondas', 'price' => 15000],
            ['name' => 'Peinados', 'price' => 15000],
        ];

        foreach ($cejas as $s) {
            Service::create([
                'name' => $s['name'],
                'category' => 'CEJAS, PESTAÑAS Y OTROS',
                'price' => $s['price'],
                'duration_minutes' => 45,
                'description' => 'Tratamiento estético facial y capilar.'
            ]);
        }

        // 3. Categoría: DEPILACIÓN
        $depilacion = [
            ['name' => 'Depilación en cera', 'price' => 15000],
            ['name' => 'Depilación en cuchilla', 'price' => 10000],
            ['name' => 'Diseño de cejas', 'price' => 20000],
            ['name' => 'Depilación de bozo', 'price' => 10000],
            ['name' => 'Depilación de axilas', 'price' => 20000],
            ['name' => 'Depilación media pierna', 'price' => 30000],
        ];

        foreach ($depilacion as $s) {
            Service::create([
                'name' => $s['name'],
                'category' => 'DEPILACIÓN',
                'price' => $s['price'],
                'duration_minutes' => 30,
                'description' => 'Eliminación de vello y perfilado.'
            ]);
        }
    }
}