<?php

namespace Database\Seeders;

use App\Models\VehicleDoor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleDoorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doors = [
            0,
            2,
            4
        ];

        foreach ($doors as $door) {
            VehicleDoor::create([
                'quantity' => $door
            ]);
        }
    }
}
