<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'state',
        'city',
        'zip',
        'neighborhood',
        'street',
        'number',
        'complement',
        'reference',
        'latitude',
        'longitude'
    ];

    public function reseller()
    {
        return $this->hasOne(Reseller::class);
    }
}
