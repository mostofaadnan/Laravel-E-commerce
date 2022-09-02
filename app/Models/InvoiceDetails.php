<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\unit;

class InvoiceDetails extends Model
{
    public function productName(){
        return $this->belongsto(Product::class,'item_id');
       
    }
    public function UnitName(){
        return $this->belongsto(unit::class,'unit_id');
       
    }
    public function invoicename(){
        return $this->belongsto(Invoice::class,'invoice_id','id');
       
    }
}
