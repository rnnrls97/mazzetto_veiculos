<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonType extends Model
{
    protected $fillable = [
        'name',
        'abbreviation',
    ];

    public function people()
    {
        return $this->hasMany(Person::class);
    }
}
