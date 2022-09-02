<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BrandCategories;

class Brand extends Model
{
    
    public function CategoryName()
    {
        return $this->hasMany(BrandCategories::class, 'brand_id');
    }
    public function getRouteKeyName()
    {
        return 'title';
    }
}
