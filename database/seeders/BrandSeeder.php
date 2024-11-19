<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Services\BrandLogoService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $carJson = Storage::disk('public')->get('seeds/brands.json');

        $brands = json_decode($carJson);

        foreach ($brands as $brand) {
            Brand::create([
                'name' => $brand->nome,
                'image_url' => '/logos/brands/' . BrandLogoService::normalizeName($brand->nome) . '.webp',
                'parallelum_id' => $brand->codigo
            ]);
        }

    }
}
