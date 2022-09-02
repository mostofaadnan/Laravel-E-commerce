<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MultiselectCategory;
use App\Models\Country;
use App\Models\state;
use App\Models\city;
use App\Models\RequrimentFile;
use App\Models\Admin;

class customer extends Model
{
    public function CustomerDebts()
    {
        return $this->hasMany(CustomerDebts::class,'customer_id','id')->where('cancel',0);
    }
    public function CategoryName()
    {
        return $this->hasMany(MultiselectCategory::class, 'parent_id')->where('type','Customer');
    }
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
    public function username()
    {
        return $this->belongsto(Admin::class, 'user_id');
    }
    public function CustomerDocument()
    {
      return $this->hasMany(CustomerDocument::class,'customer_id');
    }
}
