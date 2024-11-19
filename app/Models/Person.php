<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $fillable = [
        'person_type_id',
        'reseller_id',
        'business_sector_id',
        'address_id',
        'registration_date',
        'company_name',
        'trade_name',
        'contact',
        'cnpj_cpf',
        'state_registration',
        'phone1',
        'phone2',
        'email',
        'website',
        'observation',
        'active',
    ];

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function personType()
    {
        return $this->belongsTo(PersonType::class);
    }

    public function reseller()
    {
        return $this->belongsTo(Reseller::class);
    }

    protected function cnpjCpf(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => preg_replace('/[^0-9]/', '', $value),
            get: fn ($value) => $value
        );
    }
}
