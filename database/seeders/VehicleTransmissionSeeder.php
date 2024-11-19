<?php

namespace Database\Seeders;

use App\Models\VehicleTransmission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleTransmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transmissions = [
            'Automática',
            'Manual',
            'CVT',
            'Automatizada',
            'Semi-automática',
            'Automatizada DCT',
            'Automática Sequencial'
        ];

        foreach ($transmissions as $transmission) {
            VehicleTransmission::create([
                'name' => $transmission
            ]);
        }
    }
}
