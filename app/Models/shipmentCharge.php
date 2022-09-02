<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class shipmentCharge extends Model
{
    public function CountryName()
    {
        return $this->belongsto(Country::class, 'country_id');
    }
    public function StateName()
    {
        return $this->belongsto(state::class, 'state_id');
    }
}
