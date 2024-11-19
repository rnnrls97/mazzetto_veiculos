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
        $this->call([
            UserSeeder::class,
            ResellerSeeder::class,
            BrandSeeder::class,
            VehicleModelSeeder::class,
            VehicleTypeSeeder::class,
            VehicleFuelTypeSeeder::class,
            VehicleCondtionSeeder::class,
            VehicleStatusSeeder::class,
            VehicleTransmissionSeeder::class,
            VehicleColorSeeder::class,
            VehicleDoorSeeder::class,
            StateCitySeeder::class,
            AccessorySeeder::class
        ]);
    }
}
