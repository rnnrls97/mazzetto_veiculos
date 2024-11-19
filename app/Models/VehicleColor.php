<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleColor extends Model
{
    protected $fillable = ['name'];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
