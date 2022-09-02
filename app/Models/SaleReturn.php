<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin;
use App\Models\customer;
use App\Models\InvoiceDetails;
class SaleReturn extends Model
{
    public function CustomerName()
    {
        return $this->belongsto(customer::class, 'customer_id');
    }
    public function returnDetails()
    {
        return $this->hasMany(SaleReturnDetails::class, 'retun_id');
    }
    public function username()
    {
        return $this->belongsto(Admin::class, 'user_id');
    }
}
