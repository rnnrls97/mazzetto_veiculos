<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $address = Address::create([
            'state' => 'SP',
            'city' => 'São Paulo',
            'zip' => '00000-000',
            'neighborhood' => 'Vila Mariana',
            'street' => 'Rua Domingos de Morais',
            'number' => '2564',
            'complement' => 'Sala 3',
            'reference' => 'Próximo ao metrô Vila Mariana',
            'latitude' => '-23.5895',
            'longitude' => '-46.6323',
        ]);

        $address->reseller()->create([
            'company_name' => 'Concessionária Mazzetto',
            'trade_name' => 'Mazzetto Veículos',
            'contact' => 'Mazzetto',
            'phone1' => '(11) 4002-8922',
            'phone2' => '(11) 4002-8923',
            'email' => 'mazzetto@veiculos.com.br',
            'website' => 'https://mazzetto.com.br',
            'notes' => '',
            'active' => true,
            'head_office' => true,
        ]);
    }
}
