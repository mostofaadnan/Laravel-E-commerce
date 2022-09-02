<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpensesType extends Model
{
    public function totalAmount($type)
    {
        return $this->hasMany(Expenses::class, 'expenses_id')
            ->where('payment_type',$type);
    }
    public function totalAmountByReport($type)
    {
        return $this->hasMany(Expenses::class,'expenses_id')
            ->where('payment_type',$type);
    }
}
