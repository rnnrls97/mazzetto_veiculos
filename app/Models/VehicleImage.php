<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleImage extends Model
{
    protected $fillable = [
        'vehicle_id',
        'image_url',
        'order',
        'main_image',

    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
