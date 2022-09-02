<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class productSliderType extends Model
{
    public function SliderProduct(){
        return $this->hasMany(ProductSlider::class,'type_id');
    }
}
