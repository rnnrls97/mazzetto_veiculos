<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\State;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class StateCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $json = Storage::disk('public')->get('seeds/states_cities.json');

            $states = json_decode($json);

            foreach ($states as $state) {
                $stateModel = State::create([
                    'name' => $state->name,
                    'uf' => $state->uf,
                ]);

                foreach ($state->cities as $city) {
                    $stateModel->cities()->create([
                        'id' => $city->id,
                        'name' => $city->name,
                        'uf' => $city->uf,
                    ]);
                }
            }

        } catch (Exception $e) {    
            echo $e->getMessage();
        }
    }
}
