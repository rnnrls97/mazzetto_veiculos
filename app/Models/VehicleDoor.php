<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleDoor extends Model
{
    protected $fillable = [
        'quantity'
    ];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
