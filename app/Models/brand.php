<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'name', 
        'image_url'
    ];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function brandModels()
    {
        return $this->hasMany(BrandModel::class);
    }
}
