<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\BrandModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class VehicleModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = Brand::all();

        foreach ($brands as $brand) {
            $response = Http::get("https://parallelum.com.br/fipe/api/v1/carros/marcas/{$brand->parallelum_id}/modelos")->json();

            foreach ($response['modelos'] as $model) {
                $modelo = explode(' ', $model['nome']);

                $brandModel = BrandModel::firstWhere('name', $modelo[0]);

                if (!$brandModel) {
                    $brandModel = $brand->brandModels()->create([
                        'name' => $modelo[0],
                        'parallelum_id' => $model['codigo'] 
                    ]);
                }

                if(count($modelo) > 1) {
                    $versionName = implode(' ', array_slice($modelo, 1));

                    $brandModel->versions()->create([
                        'name' => $versionName,
                    ]);

                }
            }
        }

    }
}
