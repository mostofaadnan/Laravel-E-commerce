<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleReturnDetails extends Model
{
    public function productName()
    {
        return $this->belongsto(Product::class, 'item_id');
    }
}
