<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelVersion extends Model
{
    protected $fillable = [
        'brand_model_id',
        'name'
    ];

    public function brandModel()
    {
        return $this->belongsTo(BrandModel::class);
    }
}
