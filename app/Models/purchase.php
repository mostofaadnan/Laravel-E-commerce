<?php

namespace App\Models;

use App\Models\purchasedetails;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin;

class purchase extends Model
{
    protected $table = "purchases";
    public function SupplierName()
    {
        return $this->belongsto(supplier::class, 'supplier_id', 'id');
    }

    public function PDetails()
    {
        return $this->hasMany(purchasedetails::class, 'purchase_id');
    }
    public function username()
    {
        return $this->belongsto(Admin::class, 'user_id');
    }
}
