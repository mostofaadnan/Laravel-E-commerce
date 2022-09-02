<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ExpensesType;
use App\Models\Admin;
class Expenses extends Model
{
    public function ExpnensesType(){
        return $this->belongsto(ExpensesType::class,'expenses_id');
       
    }
    
    public function username(){
        return $this->belongsto(Admin::class,'user_id');
    }

}
