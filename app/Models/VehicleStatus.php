<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleStatus extends Model
{
    protected $fillable = ['description'];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
