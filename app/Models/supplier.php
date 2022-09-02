<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MultiselectCategory;
use App\Models\Country;
use App\Models\state;
use App\Models\Admin;

class supplier extends Model
{
  public function SupplierDebt(){
    return $this->hasMany(SupplierDebt::class);
}
  public function CategoryName()
  {
    return $this->hasMany(MultiselectCategory::class, 'parent_id')->where('type','Supplier');
  }

  public function CountryName()
  {
    return $this->belongsto(Country::class, 'country_id');
  }

  public function StateName()
  {

    return $this->belongsto('App\Models\state','state_id');
  }
  public function CityName()
  {
    return $this->belongsto(city::class, 'city_id');
  }

  public function username()
  {
    return $this->belongsto(Admin::class, 'user_id');
  }
  public function SupplierDocument()
  {
    return $this->hasMany(SupplierDocument::class,'supplier_id');
  }
}
