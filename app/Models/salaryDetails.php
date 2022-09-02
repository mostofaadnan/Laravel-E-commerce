<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class salaryDetails extends Model
{
    public function employeeName(){
        return $this->belongsto(Emplyer::class,'employee_id');
       
    }
}
