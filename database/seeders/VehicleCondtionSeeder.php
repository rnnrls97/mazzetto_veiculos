<?php

namespace Database\Seeders;

use App\Models\VehicleCondition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleCondtionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $conditions = [
            'Novo',
            'Seminovo',
            'Usado',
            'Outros',
        ];

        foreach ($conditions as $condition) {
            VehicleCondition::create(['name' => $condition]);
        }
    }
}
