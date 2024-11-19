<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accessory extends Model
{
    protected $fillable = [
        'name'
    ];

    public function vehicles()
    {
        return $this->belongsToMany(Vehicle::class);
    }
}
