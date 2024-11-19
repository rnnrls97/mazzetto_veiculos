<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\VehicleType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Passeio',
                'types' => [
                    ['name' => 'Hatch'],
                    ['name' => 'Sedan'],
                    ['name' => 'SUV'],
                    ['name' => 'Picape'],
                    ['name' => 'Esportivo'],
                    ['name' => 'Conversível'],
                    ['name' => 'Cupê'],
                    ['name' => 'Perua'],
                    ['name' => 'Van'],
                    ['name' => 'Utilitário'],
                    ['name' => 'Outros'],
                ]
            ],
            [
                'name' => 'Duas/Três Rodas',
                'types' => [
                    ['name' => 'Moto'],
                    ['name' => 'Scooter'],
                    ['name' => 'Triciclo'],
                    ['name' => 'Quadriciclo'],
                    ['name' => 'Bicicleta'],
                    ['name' => 'Outros'],
                ]
            ],
        ];

        foreach ($categories as $category) {
            $categoryModel = Category::create(['name' => $category['name']]);

            foreach ($category['types'] as $type) {
                VehicleType::create([
                    'category_id' => $categoryModel->id,
                    'name' => $type['name']
                ]);
            }
        }
    }
}
