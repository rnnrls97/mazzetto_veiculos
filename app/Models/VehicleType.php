<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    protected $fillable = [
        'category_id', 
        'name'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
