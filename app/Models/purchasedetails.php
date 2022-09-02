<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\unit;

class purchasedetails extends Model
{
  
    public function productName()
    {
        return $this->belongsto(Product::class, 'itemcode')/* ->withDefault([
            'name' => 'Deleted Item',
        ]) */;
    }
    public function UnitName()
    {
        return $this->belongsto(unit::class, 'unit_id');
    }
    public function purchasename()
    {
        return $this->belongsto(purchase::class, 'purchase_id');
    }
}
