<?php

namespace Database\Seeders;

use App\Models\VehicleStatus;
use Illuminate\Database\Seeder;

class VehicleStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            'Disponível',
            'Reservado',
            'Bloqueado',
            'Proposta',
            'Vendido',
        ];

        foreach ($statuses as $status) {
            VehicleStatus::create(['description' => $status]);
        }
    }
}
