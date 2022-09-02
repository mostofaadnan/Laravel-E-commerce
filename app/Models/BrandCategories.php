<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
class BrandCategories extends Model
{

    public function CatName()
    {
        return $this->belongsto(Category::class,'category_id');
    }
    public function BrandName()
    {
        return $this->belongsto(Brand::class,'brand_id');
    }
}
