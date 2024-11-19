<?php

namespace Database\Seeders;

use App\Models\Accessory;
use Illuminate\Database\Seeder;

class AccessorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accessories = [
            'Ar condicionado',
            'Vidros elétricos',
            'Freio ABS',
            'Travas elétricas',
            'Airbag',
            'Alarme',
            'Desembaçador traseiro',
            'Computador de bordo',
            'Ar quente',
            'Rodas de liga leve',
            'Volante com regulagem de altura',
            'Retrovisores elétricos',
            'Direção hidráulica',
            'Banco com regulagem de altura',
            'Limpador traseiro',
            'Sensor de estacionamento',
            'Bancos em couro',
            'Encosto de cabeça traseiro',
            'Controle de tração',
            'Controle automático de velocidade',
            'GPS',
            'Rádio',
            'Retrovisor fotocrômico',
            'Teto solar',
            'Sensor de chuva',
            'Tração 4x4',
            'CD Player',
            'Farol de xenônio',
            'Bancos dianteiros com aquecimento',
            'CD e MP3 Player',
            'Capota marítima',
            'DVD Player',
            'Protetor de caçamba',
            'Rádio e toca fitas',
            'Disqueteira',
        ];

        foreach ($accessories as $accessory) {
            Accessory::create(['name' => $accessory]);
        }
    }
}
