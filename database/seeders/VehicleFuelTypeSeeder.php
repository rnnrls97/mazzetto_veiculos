<?php

namespace Database\Seeders;

use App\Models\VehicleFuelType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleFuelTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fuelTypes = [
            'Gasolina',
            'Álcool',
            'Diesel',
            'Flex',
            'Gás Natural',
            'Híbrido',
            'Elétrico',
            'Outros',
        ];

        foreach ($fuelTypes as $fuelType) {
            VehicleFuelType::create(['name' => $fuelType]);
        }
    }
}
