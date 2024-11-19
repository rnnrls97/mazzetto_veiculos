<?php

namespace Database\Seeders;

use App\Models\VehicleColor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            'Branco',
            'Preto',
            'Prata',
            'Cinza',
            'Vermelho',
            'Azul',
            'Verde',
            'Marrom',
            'Bege',
            'Amarelo',
            'Laranja',
            'Vinho',
            'Dourado',
            'Indefinida',
            'Bronze',
            'Roxo',
            'Rosa',
        ];

        foreach ($colors as $color) {
            VehicleColor::create([
                'name' => $color
            ]);
        }
    }
}
