<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'id',
        'name',
        'uf',
        'state_id',
    ];

    public function state()
    {
        return $this->belongsTo(State::class);
}
}
