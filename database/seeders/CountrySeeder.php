<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Country::create([
            'nome_pais' => 'Brasil',
            'sigla' => 'BR',
            'ddi' => '+55',
            'siscomex' => 'SISCOMEX',
            'cod_sped' => 'BR',
            'img_bandeira' => 'brasil.png'
        ]);

        Country::create([
            'nome_pais' => 'Estados Unidos',
            'sigla' => 'US',
            'ddi' => '+1',
            'siscomex' => 'SISCOMEX',
            'cod_sped' => 'US',
            'img_bandeira' => 'united-states.png'
        ]);

        Country::create([
            'nome_pais' => 'Alemanha',
            'sigla' => 'DE',
            'ddi' => '+49',
            'siscomex' => 'SISCOMEX',
            'cod_sped' => 'DE',
            'img_bandeira' => 'germany.png'
        ]);

        Country::create([
            'nome_pais' => 'Italia',
            'sigla' => 'IT',
            'ddi' => '+39',
            'siscomex' => 'SISCOMEX',
            'cod_sped' => 'IT',
            'img_bandeira' => 'italy.png'
        ]);

        Country::create([
            'nome_pais' => 'Inglaterra',
            'sigla' => 'GB',
            'ddi' => '+44',
            'siscomex' => 'SISCOMEX',
            'cod_sped' => 'GB',
            'img_bandeira' => 'united-kingdom.png'
        ]);

    }
}
