<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierDebt extends Model
{
    public function SupplierName()
    {
        return $this->belongsto(supplier::class, 'supplier_id');
    }
}
