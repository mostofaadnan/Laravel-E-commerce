<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderDelivery;

class Order extends Model
{
    public function CustomerName(){
        return $this->belongsto(customer::class,'customer_id');
    }
    public function CustomerBalance(){
        return $this->hasMany(CustomerDebts::class,'customer_id','customer_id')->where('cancel',0);
    }
    public function InvDetails(){
        return $this->hasMany(OrderDetails::class,'invoice_id');
    }
    public function username(){
        return $this->belongsto(User::class,'user_id');
    }
    public function DeliveryNote(){
        return $this->hasOne(OrderDelivery::class,'invoice_id');
    }
    public function payment(){
        return $this->hasOne(PaymentInfo::class,'invoice_id','id');
    }
   
}
