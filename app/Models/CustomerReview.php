<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerReview extends Model
{
    public function productName(){
        return $this->belongsto(Product::class,'product_id');
       
    }
    public function Reply(){
        return $this->hasMany(ReviewReply::class,'review_id');
    }
}
