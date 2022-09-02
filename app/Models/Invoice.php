<?php

namespace App\Models;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Models\customer;
use App\Models\InvoiceDetails;
use App\Models\Admin;
class Invoice extends Model
{
    public function CustomerName(){
        return $this->belongsto(customer::class,'customer_id');
    }
    public function CustomerBalance(){
        return $this->hasMany(CustomerDebts::class,'customer_id','customer_id')->where('cancel',0);
    }
    public function InvDetails(){
        return $this->hasMany(InvoiceDetails::class,'invoice_id');
    }
    public function username(){
        return $this->belongsto(Admin::class,'user_id');
    }
  
}
