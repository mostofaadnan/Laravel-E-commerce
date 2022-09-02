<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeProductCategory extends Model
{
    public function Categoryname()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function CategoryProduct(){
        return $this->hasMany(Product::class,'category_id','category_id');
    }
}
