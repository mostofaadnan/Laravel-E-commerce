<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    public function productName(){
        return $this->belongsto(Product::class,'item_id');
       
    }
    public function UnitName(){
        return $this->belongsto(unit::class,'unit_id');
       
    }
}
