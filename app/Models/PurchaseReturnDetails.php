<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class PurchaseReturnDetails extends Model
{
    public function ProductName()
    {
        return $this->belongsto(Product::class, 'itemcode');
    }
}
