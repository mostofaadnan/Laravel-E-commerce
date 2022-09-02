<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function CountryName()
    {
        return $this->belongsto(Country::class, 'country_id');
    }

    public function StateName()
    {
        return $this->belongsto(state::class, 'state_id');
    }
    public function CityName()
    {
        return $this->belongsto(city::class, 'city_id');
    }
}
