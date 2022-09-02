<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class state extends Model
{
    public function CountryName()
    {
        return $this->belongsto(Country::class, 'country_id');
    }
}
