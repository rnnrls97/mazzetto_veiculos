<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'reseller_id',
        'category_id',
        'vehicle_type_id',
        'brand_model_id',
        'model_version_id',
        'vehicle_condition_id',
        'vehicle_fuel_type_id',
        'vehicle_transmission_id',
        'vehicle_color_id',
        'vehicle_door_id',
        'state_id',
        'city_id',
        'year',
        'year_model',
        'value',
        'highlight',
        'payroll_loan',
        'license_plate',
        'km_mileage',
        'renavam',
        'views',
        'observation',
        'active',
        'vehicle_status_id',
        'sale_date'
    ];

    protected $appends = [
        'main_image'
    ];

    public function reseller()
    {
        return $this->belongsTo(Reseller::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function type()
    {
        return $this->belongsTo(VehicleType::class);
    }

    public function brandModel()
    {
        return $this->belongsTo(BrandModel::class);
    }

    public function modelVersion()
    {
        return $this->belongsTo(ModelVersion::class);
    }

    public function condition()
    {
        return $this->belongsTo(VehicleCondition::class);
    }

    public function fuelType()
    {
        return $this->belongsTo(VehicleFuelType::class);
    }

    public function transmission()
    {
        return $this->belongsTo(VehicleTransmission::class);
    }

    public function color()
    {
        return $this->belongsTo(VehicleColor::class);
    }

    public function door()
    {
        return $this->belongsTo(VehicleDoor::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function status()
    {
        return $this->belongsTo(VehicleStatus::class);
    }

    public function images()
    {
        return $this->hasMany(VehicleImage::class);
    }
    
    public function accessories()
    {
        return $this->belongsToMany(Accessory::class);
    }

    public function mainImage(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->images()->where('main_image', true)->first()
        );
    }
}
