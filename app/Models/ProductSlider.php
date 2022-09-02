<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSlider extends Model
{
    public function productName(){
        return $this->belongsto(Product::class,'product_id');
       
    }

    public function typeName(){
        return $this->belongsto(productSliderType::class,'type_id');
       
    }
}
