<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reseller extends Model
{
    protected $fillable = [
        'address_id',
        'company_name',
        'trade_name',
        'contact',
        'phone1',
        'phone2',
        'email',
        'website',
        'notes',
        'active',
        'head_office'
    ];

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
