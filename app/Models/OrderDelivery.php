<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDelivery extends Model
{
    public function employeeName(){
        return $this->belongsto(Emplyer::class,'employeer_id');
       
    }
}
